<?php

namespace Database\Seeders;

use App\Models\HouseType;
use Illuminate\Database\Seeder;

class HouseTypeSeeder extends Seeder
{
    public function run(): void
    {
        $types = [
            ['nama' => 'Tipe 36/72', 'luas_tanah' => 72, 'luas_bangunan' => 36, 'kamar_tidur' => 2, 'kamar_mandi' => 1, 'harga_dasar' => 520000000],
            ['nama' => 'Tipe 45/90', 'luas_tanah' => 90, 'luas_bangunan' => 45, 'kamar_tidur' => 2, 'kamar_mandi' => 1, 'harga_dasar' => 680000000],
            ['nama' => 'Tipe 60/120', 'luas_tanah' => 120, 'luas_bangunan' => 60, 'kamar_tidur' => 3, 'kamar_mandi' => 2, 'harga_dasar' => 910000000],
            ['nama' => 'Tipe 36/60', 'luas_tanah' => 60, 'luas_bangunan' => 36, 'kamar_tidur' => 2, 'kamar_mandi' => 1, 'harga_dasar' => 430000000],
            ['nama' => 'Tipe 45/84', 'luas_tanah' => 84, 'luas_bangunan' => 45, 'kamar_tidur' => 3, 'kamar_mandi' => 1, 'harga_dasar' => 590000000],
            ['nama' => 'Tipe 60/110', 'luas_tanah' => 110, 'luas_bangunan' => 60, 'kamar_tidur' => 3, 'kamar_mandi' => 2, 'harga_dasar' => 810000000],
        ];

        foreach ($types as $type) {
            HouseType::updateOrCreate(['nama' => $type['nama']], $type);
        }
    }
}
