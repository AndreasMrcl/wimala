<?php

namespace Database\Seeders;

use App\Models\Cluster;
use Illuminate\Database\Seeder;

class ClusterSeeder extends Seeder
{
    public function run(): void
    {
        $clusters = [
            ['nama' => 'Grand Taman Sari', 'lokasi' => 'Bekasi, Jawa Barat', 'deskripsi' => 'Cluster utama dengan akses tol dan fasilitas lengkap.'],
            ['nama' => 'Puri Dharmawangsa', 'lokasi' => 'Depok, Jawa Barat', 'deskripsi' => 'Cluster indent dengan konsep hunian asri.'],
        ];

        foreach ($clusters as $cluster) {
            Cluster::updateOrCreate(['nama' => $cluster['nama']], $cluster);
        }
    }
}
