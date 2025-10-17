<?php

namespace Database\Seeders;

use App\Models\Service;
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
        // ----------------------------
        // Sublimado
        // ----------------------------
        $sublimado = Service::create([
            'name' => 'Sublimado',
            'description' => 'Impresión térmica sobre materiales',
        ]);

        // Modo: Por pieza (incluye planchado)
        $modePiece = $sublimado->modes()->create([
            'name' => 'Por pieza',
            'description' => 'Incluye planchado',
            'includes_ironing' => true,
        ]);

        // Tamaños
        $sizesPiece = [
            ['name' => 'Escudo 10x10', 'width_cm' => 10, 'height_cm' => 10, 'prices' => [50, 30, 20, 12, 10, 6, 4], 'ranges' => [[1,2],[3,9],[10,49],[50,99],[100,499],[500,999],[1000,null]]],
            ['name' => 'Carta 21.5x28', 'width_cm' => 21.5, 'height_cm' => 28, 'prices' => [90, 60, 30, 28, 25, 22, 18], 'ranges' => [[1,2],[3,9],[10,49],[50,99],[100,499],[500,999],[1000,null]]],
            ['name' => 'Tabloide 27.94x48', 'width_cm' => 27.94, 'height_cm' => 48, 'prices' => [120,90,50,45,40,35,30], 'ranges' => [[1,2],[3,9],[10,49],[50,99],[100,499],[500,999],[1000,null]]],
        ];

        foreach ($sizesPiece as $sizeData) {
            $size = $modePiece->sizes()->create([
                'name' => $sizeData['name'],
                'width_cm' => $sizeData['width_cm'],
                'height_cm' => $sizeData['height_cm'],
            ]);

            foreach ($sizeData['ranges'] as $index => $range) {
                ServicePriceTier::create([
                    'service_size_id' => $size->id,
                    'min_qty' => $range[0],
                    'max_qty' => $range[1],
                    'unit_type' => 'piece',
                    'price' => $sizeData['prices'][$index],
                ]);
            }
        }

        // Modo: Por metro lineal (no incluye planchado)
        $modeMeter = $sublimado->modes()->create([
            'name' => 'Por metro lineal',
            'description' => 'No incluye planchado',
            'includes_ironing' => false,
        ]);

        // Rangos por metro
        $sizeMeter = $modeMeter->sizes()->create([
            'name' => 'Metro Lineal',
            'width_cm' => null,
            'height_cm' => null,
        ]);

        $meterPrices = [
            [1,2, 150],
            [3,10, 100],
            [11,50, 90],
            [51,100, 80],
            [101,500,72],
            [501,null,60],
        ];

        foreach ($meterPrices as $p) {
            ServicePriceTier::create([
                'service_size_id' => $sizeMeter->id,
                'min_qty' => $p[0],
                'max_qty' => $p[1],
                'unit_type' => 'meter',
                'price' => $p[2],
            ]);
        }

        // ----------------------------
        // Grabado Láser
        // ----------------------------
        $laser = Service::create([
            'name' => 'Grabado Láser',
            'description' => 'Grabado en distintos materiales',
        ]);

        // Modo: Por pieza
        $modeLaserPiece = $laser->modes()->create([
            'name' => 'Por pieza',
            'description' => 'Grabado personalizado',
            'includes_ironing' => null,
        ]);

        // RANGOS comunes (puedes ajustar min/max si prefieres >50 => 51-100, etc.)
        $ranges = [
            [1, 2],
            [3, 10],
            [11, 50],
            [51, 100],
            [101, 500],
            [501, 1000],
            [1001, null],
        ];

        // Definimos cada "columna" como un size separado con sus precios
        $laserSizes = [
            [
                'name' => 'Personalizado',
                'width_cm' => null,
                'height_cm' => null,
                'prices' => [60, 40, 30, 20, 15, 15, 15],
            ],
            [
                'name' => 'Llavero / Pluma',
                'width_cm' => null,
                'height_cm' => null,
                'prices' => [60, 30, 15, 7, 5, 4, 3],
            ],
            [
                'name' => 'Termo',
                'width_cm' => null,
                'height_cm' => null,
                'prices' => [60, 30, 25, 20, 15, 12, 10],
            ],
        ];

        foreach ($laserSizes as $sizeData) {
            $size = $modeLaserPiece->sizes()->create([
                'name' => $sizeData['name'],
                'width_cm' => $sizeData['width_cm'],
                'height_cm' => $sizeData['height_cm'],
            ]);

            foreach ($ranges as $index => $range) {
                ServicePriceTier::create([
                    'service_size_id' => $size->id,
                    'min_qty' => $range[0],
                    'max_qty' => $range[1],
                    'unit_type' => 'piece',
                    'price' => $sizeData['prices'][$index],
                ]);
            }
        }

        // ----------------------------
        // Impresión Digital
        // ----------------------------
        $impresion = Service::create([
            'name' => 'Impresión Digital',
            'description' => 'Impresión en materiales por metro lineal o m²',
        ]);

        // Modo: Por metro
        $modeMetro = $impresion->modes()->create([
            'name' => 'Por metro',
            'description' => 'Impresión de materiales por metro cuadrado',
            'includes_ironing' => null,
        ]);

        // RANGOS
        $ranges = [
            [1, 10],
            [11, 50],
            [51, 100],
            [101, 500],
            [501, 1000],
            [1001, null],
        ];

        // MATERIALES Y PRECIOS
        $materials = [
            ['name' => 'Lona Front 13oz', 'prices' => [90, 80, 70, 60, 50, 45]],
            ['name' => 'Lona Blackout', 'prices' => [110, 100, 90, 80, 70, 65]],
            ['name' => 'Lona Traslúcida 13oz', 'prices' => [250, 250, 200, 200, 200, 200]],
            ['name' => 'Lona Mesh', 'prices' => [200, 180, 160, 100, 85, 65]],
            ['name' => 'Vinil Adhesivo (Brillante, Mate, Transparente y Microperforado)', 'prices' => [160, 150, 140, 100, 80, 70]],
            ['name' => 'Vinil Adhesivo Reflectante (ML 1.22)', 'prices' => [800, 750, 700, 650, 600, 550]],
            ['name' => 'Vinil Adhesivo Reflectante (ML 0.61)', 'prices' => [400, 375, 350, 325, 300, 275]],
            ['name' => 'Polibanner', 'prices' => [250, 250, 200, 200, 200, 200]],
            ['name' => 'Película Backlight', 'prices' => [250, 250, 200, 200, 200, 200]],
            ['name' => 'Tela Canvas Algodón', 'prices' => [550, 500, 450, 400, 350, 300]],
        ];

        foreach ($materials as $material) {
            $size = $modeMetro->sizes()->create([
                'name' => $material['name'],
                'width_cm' => null,
                'height_cm' => null,
            ]);

            foreach ($ranges as $i => $range) {
                ServicePriceTier::create([
                    'service_size_id' => $size->id,
                    'min_qty' => $range[0],
                    'max_qty' => $range[1],
                    'unit_type' => 'm2',
                    'price' => $material['prices'][$i],
                ]);
            }
        }

        $this->command->info('Servicios y precios escalonados creados correctamente.');
    }
}
