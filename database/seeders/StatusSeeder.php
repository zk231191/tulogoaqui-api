<?php

namespace Database\Seeders;

use App\Models\OrderStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class StatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $status = [
            [
                'name' => 'accepted',
                'label' => 'Aceptado'
            ],[
                'name' => 'in_design',
                'label' => 'En diseño'
            ],[
                'name' => 'in_production',
                'label' => 'En producción'
            ],[
                'name' => 'ready',
                'label' => 'Listo para entregar'
            ],[
                'name' => 'finished',
                'label' => 'Finalizado'
            ],
        ];

        OrderStatus::insert($status);
    }
}
