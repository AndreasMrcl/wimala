<?php

namespace Database\Seeders;

use App\Models\Buyer;
use Illuminate\Database\Seeder;

class BuyerSeeder extends Seeder
{
    public function run(): void
    {
        $names = [
            'Andi Wijaya', 'Rina Hapsari', 'Slamet Riyadi', 'Dewi Lestari',
            'Bambang Pratama', 'Hendra Gunawan', 'Maya Sari', 'Joko Susilo',
            'Putri Anjani', 'Agus Salim', 'Sri Wahyuni', 'Teguh Saputra',
        ];

        foreach ($names as $i => $name) {
            $slug = strtolower(str_replace(' ', '.', $name));
            Buyer::updateOrCreate(['nama' => $name], [
                'ktp'     => '32750'.str_pad((string) ($i + 1), 11, '0', STR_PAD_LEFT),
                'npwp'    => '09.'.rand(100, 999).'.'.rand(100, 999).'.'.rand(1, 9).'-'.rand(100, 999).'.000',
                'telepon' => '0812'.str_pad((string) rand(0, 99999999), 8, '0', STR_PAD_LEFT),
                'email'   => $slug.'@email.test',
                'alamat'  => 'Jl. Contoh No. '.($i + 1).', Jakarta',
            ]);
        }
    }
}
