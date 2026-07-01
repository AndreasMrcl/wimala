<?php

namespace Database\Seeders;

use App\Models\Invoice;
use App\Models\Payment;
use App\Models\SaleTransaction;
use App\Models\User;
use Illuminate\Database\Seeder;

class InvoiceSeeder extends Seeder
{
    public function run(): void
    {
        $finance = User::where('role', 'finance')->value('id');
        $counter = 1;
        $no = function () use (&$counter) {
            return 'INV-'.now()->format('ym').'-'.str_pad((string) ($counter++), 4, '0', STR_PAD_LEFT);
        };

        foreach (SaleTransaction::with('unit')->get() as $i => $trx) {
            // Booking fee — selalu ada & lunas
            $bf = Invoice::create([
                'sale_transaction_id' => $trx->id,
                'no_invoice'          => $no(),
                'jenis_termin'        => 'booking_fee',
                'jumlah'              => 5000000,
                'jatuh_tempo'         => now()->subDays(30),
                'status'              => 'paid',
            ]);
            Payment::create([
                'invoice_id'   => $bf->id,
                'tanggal'      => now()->subDays(28),
                'jumlah'       => 5000000,
                'metode'       => 'transfer',
                'confirmed_by' => $finance,
            ]);

            // DP — untuk transaksi yang unit-nya sudah sold ke atas
            if (in_array($trx->unit->status, ['sold', 'handed_over', 'completed'], true)) {
                $dp      = round((float) $trx->unit->harga * 0.2);
                $variant = $i % 4; // 0 lunas, 1 sebagian, 2 belum jatuh tempo, 3 terlambat

                $inv = Invoice::create([
                    'sale_transaction_id' => $trx->id,
                    'no_invoice'          => $no(),
                    'jenis_termin'        => 'dp',
                    'jumlah'              => $dp,
                    'jatuh_tempo'         => $variant === 3 ? now()->subDays(10) : now()->addDays(15),
                    'status'              => 'unpaid',
                ]);

                if ($variant === 0) {
                    Payment::create(['invoice_id' => $inv->id, 'tanggal' => now()->subDays(5), 'jumlah' => $dp, 'metode' => 'transfer', 'confirmed_by' => $finance]);
                    $inv->update(['status' => 'paid']);
                } elseif ($variant === 1) {
                    Payment::create(['invoice_id' => $inv->id, 'tanggal' => now()->subDays(3), 'jumlah' => round($dp * 0.5), 'metode' => 'transfer', 'confirmed_by' => $finance]);
                }
            }
        }
    }
}
