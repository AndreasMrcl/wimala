<?php

namespace Database\Seeders;

use App\Models\Bank;
use Illuminate\Database\Seeder;

class BankSeeder extends Seeder
{
    public function run(): void
    {
        $banks = [
            ['nama' => 'Bank BTN',     'kontak' => '021-6336789', 'suku_bunga_acuan' => 6.50],
            ['nama' => 'Bank BCA',     'kontak' => '1500888',     'suku_bunga_acuan' => 7.25],
            ['nama' => 'Bank Mandiri', 'kontak' => '14000',       'suku_bunga_acuan' => 7.00],
            ['nama' => 'Bank BNI',     'kontak' => '1500046',     'suku_bunga_acuan' => 6.75],
        ];

        foreach ($banks as $bank) {
            Bank::updateOrCreate(['nama' => $bank['nama']], $bank);
        }
    }
}
