<?php

namespace Database\Seeders;

use App\Models\OrderSubstatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class SubstatusSeeder extends Seeder
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
                'status_id' => 2,
                'sequence' => 1,
                'is_final' => false,
            ],
            [
                'name' => 'in_progress',
                'label' => 'En proceso',
                'status_id' => 2,
                'sequence' => 2,
                'is_final' => false,
            ],
            [
                'name' => 'finished',
                'label' => 'Finalizado',
                'status_id' => 2,
                'sequence' => 3,
                'is_final' => true,
            ],
            [
                'name' => 'accepted',
                'label' => 'Aceptado',
                'status_id' => 3,
                'sequence' => 1,
                'is_final' => false,
            ],
            [
                'name' => 'in_progress',
                'label' => 'En proceso',
                'status_id' => 3,
                'sequence' => 2,
                'is_final' => false,
            ],
            [
                'name' => 'finished',
                'label' => 'Finalizado',
                'status_id' => 3,
                'sequence' => 3,
                'is_final' => true,
            ],
            [
                'name' => 'ready_for_delivery',
                'label' => 'Listo para entregar',
                'status_id' => 4,
                'sequence' => 1,
                'is_final' => false,
            ],
            [
                'name' => 'finished',
                'label' => 'Finalizado',
                'status_id' => 4,
                'sequence' => 2,
                'is_final' => true,
            ],
        ];

        OrderSubstatus::insert($substatus);
    }
}
