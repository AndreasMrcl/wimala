<?php

namespace App\Http\Controllers;

use App\Models\Bank;
use App\Models\Buyer;
use App\Models\Marketing;
use App\Models\PipelineStage;
use App\Models\SaleTransaction;
use App\Models\Unit;
use App\Services\SaleTransactionService;
use Illuminate\Http\Request;

class SaleTransactionController extends Controller
{
    public function index()
    {
        $pipelineStages = PipelineStage::orderBy('sequence')->get();

        // Bentuk untuk chip (kompatibel view): ['t'=>nama, 'tag'=>'kpr'/'indent'/null]
        $stages = $pipelineStages->map(fn ($s) => [
            't'   => $s->name,
            'tag' => $s->applicable_rule === 'payment_method=kpr' ? 'kpr'
                : ($s->applicable_rule === 'delivery_type=indent' ? 'indent' : null),
        ])->all();

        $seqIndex = $pipelineStages->values()->mapWithKeys(fn ($s, $i) => [$s->stage_code => $i]);
        $stateMap = ['done' => 'done', 'in_progress' => 'active', 'pending' => 'pending', 'skipped' => 'skip'];

        $transactions = SaleTransaction::with(['unit', 'buyer', 'stageLogs'])
            ->where('status', 'active')
            ->get();

        $deals = $transactions->map(function ($t) use ($pipelineStages, $seqIndex, $stateMap) {
            $logByCode = $t->stageLogs->keyBy('stage_code');

            $states = $pipelineStages->map(function ($s) use ($logByCode, $stateMap) {
                $st = $logByCode[$s->stage_code]->status ?? 'pending';
                return ['no' => $s->sequence, 'label' => $s->name, 'state' => $stateMap[$st] ?? 'pending'];
            })->all();

            return [
                'id'     => $t->id,
                'name'   => $t->buyer->nama,
                'code'   => $t->unit->kode,
                'stage'  => $seqIndex[$t->current_stage_code] ?? 0,
                'pay'    => $t->payment_method === 'kpr' ? 'KPR' : 'Cash',
                'indent' => $t->unit->delivery_type === 'indent',
                'states' => $states,
            ];
        })->all();

        $counts = [];
        foreach ($pipelineStages as $i => $s) {
            $counts[$i] = $transactions->where('current_stage_code', $s->stage_code)->count();
        }

        // Data untuk modal "Transaksi Baru"
        $availableUnits = Unit::with('cluster')->where('status', 'available')->orderBy('kode')->get();
        $buyers         = Buyer::orderBy('nama')->get();
        $banks          = Bank::orderBy('nama')->get();
        $marketings     = Marketing::orderBy('nama')->get();

        return view('pipeline', compact('stages', 'deals', 'counts', 'availableUnits', 'buyers', 'banks', 'marketings'));
    }

    public function store(Request $request, SaleTransactionService $service)
    {
        $data = $request->validate([
            'unit_id'        => 'required|exists:units,id',
            'buyer_id'       => 'required|exists:buyers,id',
            'marketing_id'   => 'nullable|exists:marketings,id',
            'payment_method' => 'required|in:cash_keras,cash_bertahap,kpr',
            'bank_id'        => 'nullable|required_if:payment_method,kpr|exists:banks,id',
        ]);

        $trx = $service->create($data);

        return redirect()->route('transactions.show', $trx)
            ->with('success', 'Transaksi dibuat — unit dikunci menjadi BOOKED.');
    }

    public function show(SaleTransaction $transaction)
    {
        $transaction->load(['unit.cluster', 'unit.houseType', 'buyer', 'bank', 'marketing', 'stageLogs.stage']);

        $pipelineStages = PipelineStage::orderBy('sequence')->get();
        $logByCode      = $transaction->stageLogs->keyBy('stage_code');

        $states = $pipelineStages->map(function ($s) use ($logByCode, $transaction) {
            $log = $logByCode[$s->stage_code] ?? null;
            return [
                'no'         => $s->sequence,
                'label'      => $s->name,
                'status'     => $log->status ?? 'pending',
                'is_current' => $s->stage_code === $transaction->current_stage_code,
            ];
        })->all();

        return view('pipelineShow', compact('transaction', 'states'));
    }

    public function advance(Request $request, SaleTransaction $transaction, SaleTransactionService $service)
    {
        $request->validate(['notes' => 'nullable|string|max:1000']);

        $service->advance($transaction, $request->input('notes'));

        return redirect()->route('transactions.show', $transaction)
            ->with('success', 'Tahap diselesaikan dan transaksi dilanjutkan.');
    }

    public function cancel(Request $request, SaleTransaction $transaction, SaleTransactionService $service)
    {
        $data = $request->validate(['cancelled_reason' => 'required|string|max:1000']);

        $service->cancel($transaction, $data['cancelled_reason']);

        return redirect()->route('transactions.show', $transaction)
            ->with('success', 'Transaksi dibatalkan — unit dikembalikan ke pasar.');
    }
}
