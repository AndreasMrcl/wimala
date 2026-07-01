<?php

namespace Database\Seeders;

use App\Models\CashEntry;
use Illuminate\Database\Seeder;

class CashEntrySeeder extends Seeder
{
    public function run(): void
    {
        // Kas masuk dibuat OTOMATIS oleh PaymentObserver saat pembayaran di-seed.
        // Di sini hanya kas keluar manual (biaya proyek/operasional).
        $out = [
            ['Operasional',        12000000, 'Gaji & operasional kantor',  25],
            ['Biaya Konstruksi',   85000000, 'Termin kontraktor cluster',  20],
            ['Marketing',           9500000, 'Iklan & pameran',            15],
            ['Komisi Sales',       18000000, 'Komisi penjualan',            8],
            ['Pajak & Retribusi',   6500000, 'PBB & retribusi',             5],
            ['Operasional',        11000000, 'Listrik, air, internet',      2],
        ];

        foreach ($out as [$kategori, $jumlah, $keterangan, $daysAgo]) {
            CashEntry::create([
                'tanggal'    => now()->subDays($daysAgo),
                'tipe'       => 'out',
                'kategori'   => $kategori,
                'jumlah'     => $jumlah,
                'keterangan' => $keterangan,
            ]);
        }
    }
}
