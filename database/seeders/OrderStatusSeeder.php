<?php

namespace Database\Seeders;

use App\Models\OrderStatus;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class OrderStatusSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $statuses = [
            [
                'name' => 'pending',
                'label' => 'Pendiente'
            ], [
                'name' => 'pending',
                'label' => 'Pendiente'
            ], [
                'name' => 'finished',
                'label' => 'Finalizado'
            ], [
                'name' => 'cancelled',
                'label' => 'Cancelado'
            ], [
                'name' => 'shipped',
                'label' => 'Entregado'
            ]
        ];

        foreach ($statuses as $status) {
            OrderStatus::create($status);
        }
    }
}
