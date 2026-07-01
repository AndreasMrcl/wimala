<?php

namespace Database\Seeders;

use App\Models\Marketing;
use Illuminate\Database\Seeder;

class MarketingSeeder extends Seeder
{
    public function run(): void
    {
        $marketings = [
            ['nama' => 'Sales A — Budi',  'telepon' => '081200000001', 'area' => 'Grand Taman Sari'],
            ['nama' => 'Sales B — Citra', 'telepon' => '081200000002', 'area' => 'Puri Dharmawangsa'],
            ['nama' => 'Sales C — Eka',   'telepon' => '081200000003', 'area' => 'Umum'],
        ];

        foreach ($marketings as $marketing) {
            Marketing::updateOrCreate(['nama' => $marketing['nama']], $marketing);
        }
    }
}
