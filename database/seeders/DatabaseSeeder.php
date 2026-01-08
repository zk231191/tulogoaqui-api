<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->call([
            RolePermissionSeeder::class,
            UserSeeder::class,
            CustomerSeeder::class,
            ServiceSeeder::class,
            SatRegimeSeeder::class,
            SatCfdiUseSeeder::class,
            SatRegimeCfdiUseSeeder::class,
            OrderStatusSeeder::class,
            OrderServiceStatusSeeder::class,
            OrderServiceSubstatusSeeder::class,
            PaymentMethodSeeder::class,
        ]);
    }
}
