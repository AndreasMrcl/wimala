<?php

namespace App\Services;

use App\Models\PipelineStage;
use App\Models\SaleTransaction;
use App\Models\TransactionStageLog;
use App\Models\Unit;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

/**
 * State machine penjualan (PRD §6).
 * Dua lapisan status: status unit (inventory) digerakkan oleh tahapan transaksi.
 */
class SaleTransactionService
{
    /**
     * Buat transaksi: kunci unit (cegah double-sell), instansiasi 8 tahap
     * (tahap tak relevan -> SKIPPED), Booking jadi aktif, unit -> BOOKED.
     */
    public function create(array $data): SaleTransaction
    {
        return DB::transaction(function () use ($data) {
            /** @var Unit $unit */
            $unit = Unit::lockForUpdate()->findOrFail($data['unit_id']);

            if ($unit->status !== 'available') {
                throw ValidationException::withMessages([
                    'unit_id' => 'Unit tidak tersedia — mencegah penjualan ganda.',
                ]);
            }

            $stages    = PipelineStage::orderBy('sequence')->get();
            $firstCode = $stages->first()->stage_code;

            $trx = SaleTransaction::create([
                'unit_id'            => $unit->id,
                'buyer_id'           => $data['buyer_id'],
                'marketing_id'       => $data['marketing_id'] ?? null,
                'payment_method'     => $data['payment_method'],
                'bank_id'            => $data['payment_method'] === 'kpr' ? ($data['bank_id'] ?? null) : null,
                'current_stage_code' => $firstCode,
                'status'             => 'active',
            ]);

            foreach ($stages as $stage) {
                $applicable = $this->isApplicable($stage, $trx->payment_method, $unit->delivery_type);
                $isFirst    = $stage->stage_code === $firstCode;

                TransactionStageLog::create([
                    'sale_transaction_id' => $trx->id,
                    'stage_code'          => $stage->stage_code,
                    'status'              => ! $applicable ? 'skipped' : ($isFirst ? 'in_progress' : 'pending'),
                    'started_at'          => $isFirst ? now() : null,
                    'pic_user_id'         => auth()->id(),
                ]);
            }

            $unit->update(['status' => 'booked']);

            return $trx;
        });
    }

    /**
     * Selesaikan tahap aktif, terapkan pemicu status unit, lalu aktifkan
     * tahap PENDING terdekat. Bila tak ada lagi -> transaksi selesai (COMPLETED).
     */
    public function advance(SaleTransaction $trx, ?string $notes = null): SaleTransaction
    {
        return DB::transaction(function () use ($trx, $notes) {
            if ($trx->status !== 'active') {
                throw ValidationException::withMessages([
                    'status' => 'Transaksi tidak aktif, tidak bisa dilanjutkan.',
                ]);
            }

            $currentLog   = $trx->stageLogs()->where('stage_code', $trx->current_stage_code)->first();
            $currentStage = PipelineStage::find($trx->current_stage_code);

            $currentLog->update([
                'status'       => 'done',
                'completed_at' => now(),
                'pic_user_id'  => auth()->id() ?? $currentLog->pic_user_id,
                'notes'        => $notes ?? $currentLog->notes,
            ]);

            // Pemicu status unit (PRD §6.2)
            if (in_array($currentStage->unit_status_trigger, ['sold', 'handed_over', 'completed'], true)) {
                $trx->unit->update(['status' => $currentStage->unit_status_trigger]);
            }

            // Tahap aktif berikutnya = tahap PENDING dengan sequence terdekat
            $next = $trx->stageLogs()
                ->where('transaction_stage_logs.status', 'pending')
                ->join('pipeline_stages', 'transaction_stage_logs.stage_code', '=', 'pipeline_stages.stage_code')
                ->orderBy('pipeline_stages.sequence')
                ->select('transaction_stage_logs.*')
                ->first();

            if ($next) {
                $next->update(['status' => 'in_progress', 'started_at' => now()]);
                $trx->update(['current_stage_code' => $next->stage_code]);
            } else {
                $trx->update(['status' => 'completed']);
                $trx->unit->update(['status' => 'completed']);
            }

            return $trx->refresh();
        });
    }

    /**
     * Batalkan transaksi: simpan alasan, kembalikan unit ke pasar bila belum
     * serah terima, pertahankan seluruh log (tidak dihapus).
     */
    public function cancel(SaleTransaction $trx, string $reason): SaleTransaction
    {
        return DB::transaction(function () use ($trx, $reason) {
            if ($trx->status !== 'active') {
                throw ValidationException::withMessages([
                    'status' => 'Hanya transaksi aktif yang bisa dibatalkan.',
                ]);
            }

            $trx->update(['status' => 'cancelled', 'cancelled_reason' => $reason]);

            if (in_array($trx->unit->status, ['booked', 'sold'], true)) {
                $trx->unit->update(['status' => 'available']);
            }

            return $trx->refresh();
        });
    }

    private function isApplicable(PipelineStage $stage, string $paymentMethod, string $deliveryType): bool
    {
        return match ($stage->applicable_rule) {
            'payment_method=kpr'   => $paymentMethod === 'kpr',
            'delivery_type=indent' => $deliveryType === 'indent',
            default                => true, // 'always'
        };
    }
}
