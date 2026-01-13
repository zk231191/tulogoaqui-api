<?php

namespace Database\Seeders;

use App\Models\Branch;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BranchSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $sucursales = [
            [
                'name' => 'Tu logo aquí',
                'code' => 'Local'
            ], [
                'name' => 'Yelos',
                'code' => 'Yelos'
            ]
        ];

        foreach ($sucursales as $sucursal) {
            Branch::create($sucursal);
        }
    }
}
