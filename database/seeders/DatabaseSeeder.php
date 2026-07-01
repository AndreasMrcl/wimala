<?php

namespace Database\Seeders;

use App\Models\User;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    // Model events DIBIARKAN aktif agar PaymentObserver membuat kas masuk otomatis saat seeding.

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Akun per peran (PRD §3) — password default: "password"
        $users = [
            ['name' => 'Direktur Wimala',  'email' => 'direktur@wimala.test',  'role' => 'direktur'],
            ['name' => 'Finance Wimala',   'email' => 'finance@wimala.test',   'role' => 'finance'],
            ['name' => 'Marketing Wimala', 'email' => 'marketing@wimala.test', 'role' => 'marketing'],
            ['name' => 'Admin Proyek',     'email' => 'admin@wimala.test',     'role' => 'admin'],
        ];

        foreach ($users as $user) {
            User::updateOrCreate(
                ['email' => $user['email']],
                [...$user, 'password' => 'password'],
            );
        }

        $this->call([
            ClusterSeeder::class,
            HouseTypeSeeder::class,
            UnitSeeder::class,
            BuyerSeeder::class,
            BankSeeder::class,
            MarketingSeeder::class,
            PipelineStageSeeder::class,
            SaleTransactionSeeder::class,
            InvoiceSeeder::class,
            CashEntrySeeder::class,
        ]);
    }
}
