<?php

namespace Database\Seeders;

use App\Models\Bank;
use App\Models\Buyer;
use App\Models\Marketing;
use App\Models\Unit;
use App\Services\SaleTransactionService;
use Illuminate\Database\Seeder;

class SaleTransactionSeeder extends Seeder
{
    public function run(): void
    {
        $service = app(SaleTransactionService::class);

        // [kode unit, nama pembeli, cara bayar, target tahap aktif (atau 'completed')]
        $plan = [
            ['A-02', 'Maya Sari',       'kpr',           'serah_terima'], // -> sold
            ['A-03', 'Dewi Lestari',    'kpr',           'kpr'],          // -> booked
            ['A-05', 'Teguh Saputra',   'cash_keras',    'completed'],    // -> completed
            ['A-08', 'Agus Salim',      'kpr',           'ajb'],          // -> handed_over
            ['B-04', 'Joko Susilo',     'cash_bertahap', 'pembayaran'],   // -> sold
            ['B-09', 'Bambang Pratama', 'kpr',           'verifikasi'],   // -> booked
            ['B-11', 'Hendra Gunawan',  'kpr',           'pembayaran'],   // -> sold
            ['C-04', 'Slamet Riyadi',   'cash_keras',    'booking'],      // -> booked
            ['C-07', 'Sri Wahyuni',     'kpr',           'ajb'],          // -> handed_over
            ['C-10', 'Putri Anjani',    'kpr',           'konstruksi'],   // -> sold
        ];

        foreach ($plan as [$kode, $buyerName, $payment, $target]) {
            $unit = Unit::where('kode', $kode)->first();
            if (! $unit || $unit->status !== 'available') {
                continue;
            }

            $trx = $service->create([
                'unit_id'        => $unit->id,
                'buyer_id'       => Buyer::where('nama', $buyerName)->value('id'),
                'marketing_id'   => Marketing::inRandomOrder()->value('id'),
                'payment_method' => $payment,
                'bank_id'        => $payment === 'kpr' ? Bank::inRandomOrder()->value('id') : null,
            ]);

            if ($target === 'completed') {
                while ($trx->status === 'active') {
                    $trx = $service->advance($trx);
                }
            } else {
                $guard = 0;
                while ($trx->current_stage_code !== $target && $trx->status === 'active' && $guard++ < 10) {
                    $trx = $service->advance($trx);
                }
            }
        }
    }
}
