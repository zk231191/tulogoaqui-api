<?php

namespace Database\Seeders;

use App\Models\Service;
use App\Models\ServiceMode;
use App\Models\ServiceModeType;
use App\Models\ServicePriceTier;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $types = [
            'Tamaño',
            'Pieza',
            'Puntadas',
            'Tintas',
            'Material',
        ];

        foreach ($types as $type) {
            ServiceModeType::create([
                'name' => $type
            ]);
        }

        // ----------------------------
        // Sublimado
        // ----------------------------
        $sublimado = Service::create([
            'name' => 'Sublimado'
        ]);

        // Modo: Por pieza (incluye planchado)
        $mode = $sublimado->modes()->create([
            'name' => 'Por pieza',
            'description' => 'Incluye planchado',
            'type_id' => 1
        ]);

        // Tamaños (estos realmente son sub-modos del modo "Por pieza")
        $prices = [
            ['name' => 'Escudo', 'description' => '10x10', 'prices' => [50, 30, 20, 12, 10, 6, 4], 'ranges' => [[1,2],[3,9],[10,49],[50,99],[100,499],[500,999],[1000,null]]],
            ['name' => 'Carta', 'description' => '21.5x28', 'prices' => [90, 60, 30, 28, 25, 22, 18], 'ranges' => [[1,2],[3,9],[10,49],[50,99],[100,499],[500,999],[1000,null]]],
            ['name' => 'Tabloide', 'description' => '27.94x48', 'prices' => [120,90,50,45,40,35,30], 'ranges' => [[1,2],[3,9],[10,49],[50,99],[100,499],[500,999],[1000,null]]],
        ];

        foreach ($prices as $price) {
            foreach ($price['prices'] as $key => $item) {
                $range = $price['ranges'][$key];
                $mode->prices()->create([
                    'name' => $price['name'],
                    'description' => $price['description'],
                    'min_qty' => $range[0],
                    'max_qty' => $range[1],
                    'price' => $item,
                ]);
            }
        }

        $this->command->info('Servicios y precios escalonados creados correctamente.');
    }
}
