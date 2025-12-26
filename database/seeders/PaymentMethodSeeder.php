<?php

namespace Database\Seeders;

use App\Models\PaymentMethod;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PaymentMethodSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $methods = [
            [
                'name' => 'cash',
                'label' => 'Efectivo',
            ],
            [
                'name' => 'card',
                'label' => 'Tarjeta crédito/débito',
            ],
            [
                'name' => 'transfer',
                'label' => 'Transferencia',
            ],
        ];

        foreach ($methods as $method) {
            PaymentMethod::create($method);
        }
    }
}
