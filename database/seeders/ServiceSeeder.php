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

        $this->sublimado();

        $this->laser();

        $this->bordado();

        $this->dtf_uv();

        $this->dtf_textil();

        $this->serigrafia();

        $this->impresion_digital();

        $this->lanyards();

        $this->command->info('Servicios y precios escalonados creados correctamente.');
    }

    private function sublimado(): void
    {
        $this->start('sublimado');

        $sublimado = $this->createService('Sublimado');

        // Modo: Por pieza (incluye planchado)
        $mode = $sublimado->modes()->create([
            'name' => 'Por pieza',
            'description' => 'Incluye planchado',
            'type_id' => 1
        ]);

        $ranges = [[1,2],[3,9],[10,49],[50,99],[100,499],[500,999],[1000,null]];
        $prices = [
            ['name' => 'Escudo', 'description' => '10x10', 'prices' => [50, 30, 20, 12, 10, 6, 4], 'ranges' => $ranges],
            ['name' => 'Carta', 'description' => '21.5x28', 'prices' => [90, 60, 30, 28, 25, 22, 18], 'ranges' => $ranges],
            ['name' => 'Tabloide', 'description' => '27.94x48', 'prices' => [120,90,50,45,40,35,30], 'ranges' => $ranges],
        ];

        $this->savePrices($prices, $mode);

        $mode = $sublimado->modes()->create([
            'name' => 'Por Metro Lineal',
            'description' => 'No incluye planchado',
            'type_id' => 1
        ]);

        $ranges = [[1,2],[3,10],[11,50],[51,100],[101,null]];
        $prices = [
            ['name' => 'M2', 'description' => 'Metros', 'prices' => [150, 100, 80, 60, 45], 'ranges' => $ranges],
            ['name' => '0.90', 'description' => 'Metros', 'prices' => [135, 90, 72, 54, 40.5], 'ranges' => $ranges],
            ['name' => '1.20', 'description' => 'Metros', 'prices' => [180, 120, 96, 72, 54], 'ranges' => $ranges],
            ['name' => '1.60', 'description' => 'Metros', 'prices' => [240, 160, 128, 96, 72], 'ranges' => $ranges],
        ];

        $this->savePrices($prices, $mode);

        $this->end('sublimado');
    }

    private function laser(): void
    {
        $this->start('laser');

        $laser = $this->createService('Láser');

        $mode = $laser->modes()->create([
            'name' => 'Por pieza',
            'description' => '',
            'type_id' => 2
        ]);

        $ranges = [[1,2],[3,10],[11,50],[51,100],[101,500], [501,1000], [1001,null]];
        $prices = [
            ['name' => 'Personalizado', 'description' => '', 'prices' => [60, 40, 30, 20, 15, 15, 15], 'ranges' => $ranges],
            ['name' => 'Llavero / Pluma', 'description' => '', 'prices' => [60, 30, 15, 7, 5, 4, 3], 'ranges' => $ranges],
            ['name' => 'Termo', 'description' => '', 'prices' => [60, 30, 25, 20, 15, 12, 10], 'ranges' => $ranges],
        ];

        $this->savePrices($prices, $mode);

        $this->end('láser');
    }

    private function bordado(): void
    {
        $this->start('bordado');

        $bordado = $this->createService('Bordado');

        $mode = $bordado->modes()->create([
            'name' => 'Puntadas',
            'description' => '',
            'type_id' => 3
        ]);

        $ranges = [[1,2],[3,10],[11,99],[100,499], [500,999], [1000,null]];

        $prices = [
            ['name' => 'Hasta 5000', 'description' => '', 'prices' => [50, 30, 25, 15, 12.5, 10], 'ranges' => $ranges],
            ['name' => 'Más de 5000', 'description' => 'MP (Millar de puntadas)', 'prices' => [10, 6, 5, 3, 2.5, 1.9], 'ranges' => $ranges],
            ['name' => 'Personalizado', 'description' => '', 'prices' => [50, 30, 25, 15, 12.5, 10], 'ranges' => $ranges],
        ];

        $this->savePrices($prices, $mode);

        $this->end('bordado');
    }

    private function dtf_uv(): void
    {
        $this->start('dtf uv');

        $dtf = $this->createService('DTF UV');

        $mode = $dtf->modes()->create([
            'name' => 'Tamaño',
            'description' => 'Incluye aplicación',
            'type_id' => 1
        ]);

        $ranges = [[1,2],[3,9],[10,49],[50,99], [100,499], [500,999], [1000,null]];

        $prices = [
            ['name' => 'CH', 'description' => '5cm X 5cm', 'prices' => [70, 50, 30, 25, 20, 15, 10], 'ranges' => $ranges],
            ['name' => 'M', 'description' => '8cm X 8cm', 'prices' => [80, 60, 40, 35, 30, 25, 20], 'ranges' => $ranges],
            ['name' => 'G', 'description' => '14cm X 14cm', 'prices' => [90, 80, 60, 55, 50, 45, 40], 'ranges' => $ranges],
        ];

        $this->savePrices($prices, $mode);

        $mode = $dtf->modes()->create([
            'name' => 'Por Metro Lineal',
            'description' => 'No Incluye aplicación',
            'type_id' => 1
        ]);

        $ranges = [[1,null]];

        $prices = [
            ['name' => 'Mini', 'description' => '30cm X 58cm', 'prices' => [200], 'ranges' => $ranges],
            ['name' => 'Medio metro', 'description' => '', 'prices' => [280], 'ranges' => $ranges],
            ['name' => '1 Metro', 'description' => '', 'prices' => [500], 'ranges' => $ranges],
            ['name' => '5 a 14 Metros', 'description' => '', 'prices' => [450], 'ranges' => $ranges],
            ['name' => '15 Metros o más', 'description' => '', 'prices' => [390], 'ranges' => $ranges],
        ];

        $this->savePrices($prices, $mode);

        $this->end('dtf uv');
    }

    private function dtf_textil(): void
    {
        $this->start('dtf textil');

        $dtf = $this->createService('DTF Textil');

        $mode = $dtf->modes()->create([
            'name' => 'Por Pieza',
            'description' => 'Incluye planchado',
            'type_id' => 1
        ]);

        $ranges = [[1,2],[3,9],[10,49],[50,99], [100,499], [500,999], [1000,null]];

        $prices = [
            ['name' => 'Escudo', 'description' => '10cm X 10cm', 'prices' => [50, 30, 25, 18, 12, 8, 6], 'ranges' => $ranges],
            ['name' => 'Carta', 'description' => '21.5cm X 28cm', 'prices' => [90, 60, 50, 40, 35, 30, 28], 'ranges' => $ranges],
            ['name' => 'Tabloide', 'description' => '27.94cm X 48cm', 'prices' => [120, 90, 80, 70, 65, 60, 58], 'ranges' => $ranges],
        ];

        $this->savePrices($prices, $mode);

        $mode = $dtf->modes()->create([
            'name' => 'Por Metro Lineal',
            'description' => 'No Incluye aplicación',
            'type_id' => 1
        ]);

        $ranges = [[1,null]];

        $prices = [
            ['name' => 'Mini', 'description' => '30cm X 58cm', 'prices' => [90], 'ranges' => $ranges],
            ['name' => 'Medio metro', 'description' => '', 'prices' => [145], 'ranges' => $ranges],
            ['name' => '1 Metro', 'description' => '', 'prices' => [290], 'ranges' => $ranges],
            ['name' => '5 a 14 Metros', 'description' => '', 'prices' => [250], 'ranges' => $ranges],
            ['name' => '15 Metros o más', 'description' => '', 'prices' => [220], 'ranges' => $ranges],
        ];

        $this->savePrices($prices, $mode);

        $this->end('dtf textil');
    }

    private function serigrafia(): void
    {
        $this->start('serigrafía');

        $serigrafia = $this->createService('Serigrafía');

        $mode = $serigrafia->modes()->create([
            'name' => 'Tintas',
            'description' => '',
            'type_id' => 4
        ]);

        $ranges = [[50,99],[100,199],[200,499],[500,999], [1000,4999], [5000,null]];

        $prices = [
            ['name' => '1', 'description' => '', 'prices' => [15, 10, 7, 4, 2.5, 1.8], 'ranges' => $ranges],
            ['name' => '2', 'description' => '', 'prices' => [25, 14, 9, 5, 3, 2.1], 'ranges' => $ranges],
            ['name' => '3', 'description' => '', 'prices' => [0, 18, 11, 6, 3.5, 2.4], 'ranges' => $ranges],
            ['name' => '4', 'description' => '', 'prices' => [0, 21, 13, 7, 4, 2.7], 'ranges' => $ranges],
            ['name' => '5', 'description' => '', 'prices' => [0, 27, 15, 8, 4.5, 3], 'ranges' => $ranges],
            ['name' => '6', 'description' => '', 'prices' => [0, 30, 17, 9, 5, 3.3], 'ranges' => $ranges],
            ['name' => '7', 'description' => '', 'prices' => [0, 0, 0, 0, 6, 4], 'ranges' => $ranges],
            ['name' => '8', 'description' => '', 'prices' => [0, 0, 0, 0, 7, 5], 'ranges' => $ranges],
            ['name' => '9', 'description' => '', 'prices' => [0, 0, 0, 0, 8, 6], 'ranges' => $ranges],
            ['name' => '10', 'description' => '', 'prices' => [0, 0, 0, 0, 9, 7], 'ranges' => $ranges],
            ['name' => '11', 'description' => '', 'prices' => [0, 0, 0, 0, 10, 8], 'ranges' => $ranges],
            ['name' => '12', 'description' => '', 'prices' => [0, 0, 0, 0, 11, 9], 'ranges' => $ranges],
        ];

        $this->savePrices($prices, $mode);

        $this->end('serigrafía');
    }

    private function lanyards(): void
    {
        $this->start('lanyards');

        $lanyards = $this->createService('Lanyards');

        $mode = $lanyards->modes()->create([
            'name' => 'Tipo perico',
            'description' => '',
            'type_id' => 2
        ]);

        $ranges = [[50,500], [501, 1000], [1000, null]];

        $prices = [
            ['name' => '19 mm', 'description' => '', 'prices' => [18.5, 14, 13.5], 'ranges' => $ranges],
            ['name' => '25 mm', 'description' => '', 'prices' => [19.5, 15, 14.5], 'ranges' => $ranges],
        ];

        $this->savePrices($prices, $mode);

        $mode = $lanyards->modes()->create([
            'name' => 'Tipo perico y samsonite',
            'description' => '',
            'type_id' => 2
        ]);

        $prices = [
            ['name' => '19 mm', 'description' => '', 'prices' => [19.5, 15, 14.5], 'ranges' => $ranges],
            ['name' => '25 mm', 'description' => '', 'prices' => [20.5, 16, 15.5], 'ranges' => $ranges],
        ];

        $this->savePrices($prices, $mode);

        $this->end('lanyards');
    }

    private function impresion_digital(): void
    {
        $this->start('impresión digital');

        $impresion_digital = $this->createService('Impresión Digital');

        $mode = $impresion_digital->modes()->create([
            'name' => 'Por Metro',
            'description' => '',
            'type_id' => 5
        ]);

        $ranges = [[1,10],[11,50],[51,100],[101,500], [501,1000], [1001,null]];

        $prices = [
            ['name' => 'Lona Front 13oz', 'description' => '', 'prices' => [90, 80, 70, 60, 50, 45], 'ranges' => $ranges],
            ['name' => 'Lona Blackout', 'description' => '', 'prices' => [110, 100, 90, 80, 70, 65], 'ranges' => $ranges],
            ['name' => 'Lona Translucida 13oz', 'description' => '', 'prices' => [250, 250, 200, 200, 200, 200], 'ranges' => $ranges],
            ['name' => 'Lona Mesh', 'description' => '', 'prices' => [200, 180, 160, 100, 85, 65], 'ranges' => $ranges],
            ['name' => 'Vinil Adhesivo A', 'description' => 'Brillante, mate, transparente y microperforado', 'prices' => [160, 150, 140, 100, 80, 70], 'ranges' => $ranges],
            ['name' => 'Vinil Adhesivo B', 'description' => 'Reflejante (ML o 1.22)', 'prices' => [800, 750, 700, 650, 600, 550], 'ranges' => $ranges],
            ['name' => 'Vinil Adhesivo C', 'description' => 'Reflejante (ML o 0.61)', 'prices' => [400, 375, 350, 325, 300, 275], 'ranges' => $ranges],
            ['name' => 'Polibanner Blackout', 'description' => '', 'prices' => [250, 250, 200, 200, 200, 200], 'ranges' => $ranges],
            ['name' => 'Película Backlight', 'description' => '', 'prices' => [250, 250, 200, 200, 200, 200], 'ranges' => $ranges],
            ['name' => 'Tela Canvas Algodón', 'description' => '', 'prices' => [550, 500, 450, 400, 350, 300], 'ranges' => $ranges],
        ];

        $this->savePrices($prices, $mode);

        $mode = $impresion_digital->modes()->create([
            'name' => 'Por Placas',
            'description' => '',
            'type_id' => 5
        ]);

        $prices = [
            ['name' => 'Coroplast 4mm', 'description' => '1.22x2.44 m', 'prices' => [700, 600, 500, 400, 300, 250], 'ranges' => $ranges],
            ['name' => 'Trovicel 3mm', 'description' => '1.22x2.44 m', 'prices' => [900, 800, 700, 600, 500, 400], 'ranges' => $ranges],
            ['name' => 'Lado Extra A', 'description' => 'Coroplast, Trovicel', 'prices' => [200, 200, 200, 200, 150, 100], 'ranges' => $ranges],

            ['name' => 'Estireno Cal 15', 'description' => '1.52x1.20 m', 'prices' => [300, 280, 260, 240, 220, 200], 'ranges' => $ranges],
            ['name' => 'Estireno Cal 20', 'description' => '1.52x1.20 m', 'prices' => [330, 310, 290, 270, 250, 230], 'ranges' => $ranges],
            ['name' => 'Estireno Cal 30', 'description' => '1.52x1.20 m', 'prices' => [380, 360, 340, 320, 300, 280], 'ranges' => $ranges],
            ['name' => 'Estireno Cal 40', 'description' => '1.52x1.20 m', 'prices' => [510, 490, 470, 450, 430, 410], 'ranges' => $ranges],
            ['name' => 'Estireno Cal 60', 'description' => '1.52x1.20 m', 'prices' => [580, 560, 540, 520, 500, 480], 'ranges' => $ranges],
            ['name' => 'Lado Extra B', 'description' => 'Estireno', 'prices' => [100, 80, 80, 80, 70, 60], 'ranges' => $ranges],
        ];

        $this->savePrices($prices, $mode);

        $this->end('impresión digital');
    }

    private function createService(string $serviceName): Service
    {
        $satMap = [
            'Sublimado' => [
                'product' => '82121500', // Servicios de impresión
            ],
            'Láser' => [
                'product' => '73131700', // Servicios de grabado
            ],
            'Bordado' => [
                'product' => '73131600', // Personalización textil
            ],
            'DTF UV' => [
                'product' => '82121500',
            ],
            'DTF Textil' => [
                'product' => '82121500',
            ],
            'Serigrafía' => [
                'product' => '73131500', // Servicios de serigrafía
            ],
            'Impresión Digital' => [
                'product' => '82121500',
            ],
            'Lanyard' => [
                'product' => '55121800',
            ],
        ];

        return Service::create([
            'name' => $serviceName,
            'sat_product_code' => $satMap[$serviceName]['product'] ?? '73121600',
            'sat_unit_code' => 'E48',
            'sat_tax_object' => '02',
        ]);
    }
    private function start($process): void
    {
        $this->command->info('Comienza inserción de precios '.$process);
    }
    private function end($process): void
    {
        $this->command->info('Termina inserción de precios '.$process);
    }
    private function savePrices($prices, $mode): void
    {
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
    }
}
