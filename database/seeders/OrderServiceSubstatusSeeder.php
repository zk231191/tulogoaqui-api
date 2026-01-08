<?php

namespace Database\Seeders;

use App\Models\OrderServiceSubstatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderServiceSubstatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $substatus = [
            [
                'name' => 'accepted',
                'label' => 'Aceptado',
                'order_service_status_id' => 2,
                'sequence' => 1,
                'is_final' => false,
            ],
            [
                'name' => 'in_progress',
                'label' => 'En proceso',
                'order_service_status_id' => 2,
                'sequence' => 2,
                'is_final' => false,
            ],
            [
                'name' => 'finished',
                'label' => 'Finalizado',
                'order_service_status_id' => 2,
                'sequence' => 3,
                'is_final' => true,
            ],
            [
                'name' => 'accepted',
                'label' => 'Aceptado',
                'order_service_status_id' => 3,
                'sequence' => 1,
                'is_final' => false,
            ],
            [
                'name' => 'in_progress',
                'label' => 'En proceso',
                'order_service_status_id' => 3,
                'sequence' => 2,
                'is_final' => false,
            ],
            [
                'name' => 'finished',
                'label' => 'Finalizado',
                'order_service_status_id' => 3,
                'sequence' => 3,
                'is_final' => true,
            ],
            [
                'name' => 'ready_for_delivery',
                'label' => 'Listo para entregar',
                'order_service_status_id' => 4,
                'sequence' => 1,
                'is_final' => false,
            ],
            [
                'name' => 'finished',
                'label' => 'Finalizado',
                'order_service_status_id' => 4,
                'sequence' => 2,
                'is_final' => true,
            ],
        ];

        OrderServiceSubstatus::insert($substatus);
    }
}
