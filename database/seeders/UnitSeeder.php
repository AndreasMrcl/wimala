<?php

namespace Database\Seeders;

use App\Models\Cluster;
use App\Models\HouseType;
use App\Models\Unit;
use App\Support\DemoData;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    public function run(): void
    {
        // Semua unit mulai AVAILABLE; status digerakkan oleh transaksi (SaleTransactionSeeder).
        foreach (DemoData::units() as $u) {
            $cluster   = Cluster::where('nama', $u['cluster'])->first();
            $houseType = HouseType::where('nama', 'Tipe '.$u['lb'].'/'.$u['lt'])->first();

            [$blok, $nomor] = array_pad(explode('-', $u['code']), 2, null);

            Unit::updateOrCreate(['kode' => $u['code']], [
                'cluster_id'    => $cluster?->id,
                'house_type_id' => $houseType?->id,
                'blok'          => $blok,
                'nomor'         => $nomor,
                'luas_tanah'    => $u['lt'],
                'luas_bangunan' => $u['lb'],
                'harga'         => $u['harga'],
                'delivery_type' => $u['cluster'] === 'Puri Dharmawangsa' ? 'indent' : 'ready_stock',
                'status'        => 'available',
            ]);
        }
    }
}
