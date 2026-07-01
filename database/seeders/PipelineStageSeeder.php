<?php

namespace Database\Seeders;

use App\Models\PipelineStage;
use Illuminate\Database\Seeder;

class PipelineStageSeeder extends Seeder
{
    public function run(): void
    {
        // 8 tahap, satu definisi melayani 6 kombinasi (3 cara bayar × 2 jenis unit) — PRD §6.2
        $stages = [
            ['stage_code' => 'booking',      'sequence' => 1, 'name' => 'Booking',               'applicable_rule' => 'always',               'unit_status_trigger' => 'booked'],
            ['stage_code' => 'verifikasi',   'sequence' => 2, 'name' => 'Verifikasi pembeli',    'applicable_rule' => 'always',               'unit_status_trigger' => null],
            ['stage_code' => 'kpr',          'sequence' => 3, 'name' => 'Pengajuan KPR & SP2K',  'applicable_rule' => 'payment_method=kpr',   'unit_status_trigger' => null],
            ['stage_code' => 'ppjb',         'sequence' => 4, 'name' => 'PPJB',                  'applicable_rule' => 'always',               'unit_status_trigger' => 'sold'],
            ['stage_code' => 'pembayaran',   'sequence' => 5, 'name' => 'Pembayaran termin',     'applicable_rule' => 'always',               'unit_status_trigger' => null],
            ['stage_code' => 'konstruksi',   'sequence' => 6, 'name' => 'Progress konstruksi',   'applicable_rule' => 'delivery_type=indent', 'unit_status_trigger' => null],
            ['stage_code' => 'serah_terima', 'sequence' => 7, 'name' => 'Serah terima & BAST',   'applicable_rule' => 'always',               'unit_status_trigger' => 'handed_over'],
            ['stage_code' => 'ajb',          'sequence' => 8, 'name' => 'AJB & balik nama',      'applicable_rule' => 'always',               'unit_status_trigger' => 'completed'],
        ];

        foreach ($stages as $stage) {
            PipelineStage::updateOrCreate(['stage_code' => $stage['stage_code']], $stage);
        }
    }
}
