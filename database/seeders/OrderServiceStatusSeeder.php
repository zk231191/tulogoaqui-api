<?php

namespace Database\Seeders;

use App\Models\OrderServiceStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderServiceStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $status = [
            [
                'name' => 'accepted',
                'label' => 'Aceptado',
                'sequence' => 1,
            ],[
                'name' => 'in_design',
                'label' => 'En diseño',
                'sequence' => 2,
            ],[
                'name' => 'in_production',
                'label' => 'En producción',
                'sequence' => 3,
            ],[
                'name' => 'ready',
                'label' => 'Listo para entregar',
                'sequence' => 4,
            ],[
                'name' => 'finished',
                'label' => 'Finalizado',
                'sequence' => 5,
            ],
        ];

        OrderServiceStatus::insert($status);
    }
}
