<?php

namespace Database\Seeders;

use App\Models\SatRegimeCfdiUse;
use App\Models\SatRegime;
use App\Models\SatCfdiUse;
use Illuminate\Database\Seeder;

class SatRegimeCfdiUseSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Verificar que las tablas padre tengan datos
        $regimesCount = SatRegime::count();
        $cfdiUsesCount = SatCfdiUse::count();

        if ($regimesCount === 0) {
            $this->command->error('No hay regímenes en sat_regimes. Ejecuta SatRegimeSeeder primero.');
            return;
        }

        if ($cfdiUsesCount === 0) {
            $this->command->error('No hay usos de CFDI en sat_cfdi_uses. Ejecuta SatCfdiUseSeeder primero.');
            return;
        }

        $data = [
            // G01 – Adquisición de mercancías (aplica para estos regímenes)
            ['regime_code' => '601', 'cfdi_use_code' => 'G01'],
            ['regime_code' => '603', 'cfdi_use_code' => 'G01'],
            ['regime_code' => '606', 'cfdi_use_code' => 'G01'],
            ['regime_code' => '612', 'cfdi_use_code' => 'G01'],
            ['regime_code' => '620', 'cfdi_use_code' => 'G01'],
            ['regime_code' => '621', 'cfdi_use_code' => 'G01'],
            ['regime_code' => '622', 'cfdi_use_code' => 'G01'],
            ['regime_code' => '623', 'cfdi_use_code' => 'G01'],
            ['regime_code' => '624', 'cfdi_use_code' => 'G01'],
            ['regime_code' => '625', 'cfdi_use_code' => 'G01'],
            ['regime_code' => '626', 'cfdi_use_code' => 'G01'],

            // G02 – Devoluciones, descuentos o bonificaciones
            ['regime_code' => '601', 'cfdi_use_code' => 'G02'],
            ['regime_code' => '603', 'cfdi_use_code' => 'G02'],
            ['regime_code' => '606', 'cfdi_use_code' => 'G02'],
            ['regime_code' => '612', 'cfdi_use_code' => 'G02'],
            ['regime_code' => '616', 'cfdi_use_code' => 'G02'],
            ['regime_code' => '620', 'cfdi_use_code' => 'G02'],
            ['regime_code' => '621', 'cfdi_use_code' => 'G02'],
            ['regime_code' => '622', 'cfdi_use_code' => 'G02'],
            ['regime_code' => '623', 'cfdi_use_code' => 'G02'],
            ['regime_code' => '624', 'cfdi_use_code' => 'G02'],
            ['regime_code' => '625', 'cfdi_use_code' => 'G02'],
            ['regime_code' => '626', 'cfdi_use_code' => 'G02'],

            // G03 – Gastos en general
            ['regime_code' => '601', 'cfdi_use_code' => 'G03'],
            ['regime_code' => '603', 'cfdi_use_code' => 'G03'],
            ['regime_code' => '606', 'cfdi_use_code' => 'G03'],
            ['regime_code' => '612', 'cfdi_use_code' => 'G03'],
            ['regime_code' => '620', 'cfdi_use_code' => 'G03'],
            ['regime_code' => '621', 'cfdi_use_code' => 'G03'],
            ['regime_code' => '622', 'cfdi_use_code' => 'G03'],
            ['regime_code' => '623', 'cfdi_use_code' => 'G03'],
            ['regime_code' => '624', 'cfdi_use_code' => 'G03'],
            ['regime_code' => '625', 'cfdi_use_code' => 'G03'],
            ['regime_code' => '626', 'cfdi_use_code' => 'G03'],

            // I01 – Construcciones
            ['regime_code' => '601', 'cfdi_use_code' => 'I01'],
            ['regime_code' => '603', 'cfdi_use_code' => 'I01'],
            ['regime_code' => '606', 'cfdi_use_code' => 'I01'],
            ['regime_code' => '612', 'cfdi_use_code' => 'I01'],
            ['regime_code' => '620', 'cfdi_use_code' => 'I01'],
            ['regime_code' => '621', 'cfdi_use_code' => 'I01'],
            ['regime_code' => '622', 'cfdi_use_code' => 'I01'],
            ['regime_code' => '623', 'cfdi_use_code' => 'I01'],
            ['regime_code' => '624', 'cfdi_use_code' => 'I01'],
            ['regime_code' => '625', 'cfdi_use_code' => 'I01'],
            ['regime_code' => '626', 'cfdi_use_code' => 'I01'],

            // I02 – Mobilario y equipo de oficina por inversiones
            ['regime_code' => '601', 'cfdi_use_code' => 'I02'],
            ['regime_code' => '603', 'cfdi_use_code' => 'I02'],
            ['regime_code' => '606', 'cfdi_use_code' => 'I02'],
            ['regime_code' => '612', 'cfdi_use_code' => 'I02'],
            ['regime_code' => '620', 'cfdi_use_code' => 'I02'],
            ['regime_code' => '621', 'cfdi_use_code' => 'I02'],
            ['regime_code' => '622', 'cfdi_use_code' => 'I02'],
            ['regime_code' => '623', 'cfdi_use_code' => 'I02'],
            ['regime_code' => '624', 'cfdi_use_code' => 'I02'],
            ['regime_code' => '625', 'cfdi_use_code' => 'I02'],
            ['regime_code' => '626', 'cfdi_use_code' => 'I02'],

            // I03 – Equipo de transporte
            ['regime_code' => '601', 'cfdi_use_code' => 'I03'],
            ['regime_code' => '603', 'cfdi_use_code' => 'I03'],
            ['regime_code' => '606', 'cfdi_use_code' => 'I03'],
            ['regime_code' => '612', 'cfdi_use_code' => 'I03'],
            ['regime_code' => '620', 'cfdi_use_code' => 'I03'],
            ['regime_code' => '621', 'cfdi_use_code' => 'I03'],
            ['regime_code' => '622', 'cfdi_use_code' => 'I03'],
            ['regime_code' => '623', 'cfdi_use_code' => 'I03'],
            ['regime_code' => '624', 'cfdi_use_code' => 'I03'],
            ['regime_code' => '625', 'cfdi_use_code' => 'I03'],
            ['regime_code' => '626', 'cfdi_use_code' => 'I03'],

            // I04 – Equipo de computo y accesorios
            ['regime_code' => '601', 'cfdi_use_code' => 'I04'],
            ['regime_code' => '603', 'cfdi_use_code' => 'I04'],
            ['regime_code' => '606', 'cfdi_use_code' => 'I04'],
            ['regime_code' => '612', 'cfdi_use_code' => 'I04'],
            ['regime_code' => '620', 'cfdi_use_code' => 'I04'],
            ['regime_code' => '621', 'cfdi_use_code' => 'I04'],
            ['regime_code' => '622', 'cfdi_use_code' => 'I04'],
            ['regime_code' => '623', 'cfdi_use_code' => 'I04'],
            ['regime_code' => '624', 'cfdi_use_code' => 'I04'],
            ['regime_code' => '625', 'cfdi_use_code' => 'I04'],
            ['regime_code' => '626', 'cfdi_use_code' => 'I04'],

            // I05 – Dados, troqueles, moldes, matrices y herramental
            ['regime_code' => '601', 'cfdi_use_code' => 'I05'],
            ['regime_code' => '603', 'cfdi_use_code' => 'I05'],
            ['regime_code' => '606', 'cfdi_use_code' => 'I05'],
            ['regime_code' => '612', 'cfdi_use_code' => 'I05'],
            ['regime_code' => '620', 'cfdi_use_code' => 'I05'],
            ['regime_code' => '621', 'cfdi_use_code' => 'I05'],
            ['regime_code' => '622', 'cfdi_use_code' => 'I05'],
            ['regime_code' => '623', 'cfdi_use_code' => 'I05'],
            ['regime_code' => '624', 'cfdi_use_code' => 'I05'],
            ['regime_code' => '625', 'cfdi_use_code' => 'I05'],
            ['regime_code' => '626', 'cfdi_use_code' => 'I05'],

            // I06 – Comunicaciones telefónicas
            ['regime_code' => '601', 'cfdi_use_code' => 'I06'],
            ['regime_code' => '603', 'cfdi_use_code' => 'I06'],
            ['regime_code' => '606', 'cfdi_use_code' => 'I06'],
            ['regime_code' => '612', 'cfdi_use_code' => 'I06'],
            ['regime_code' => '620', 'cfdi_use_code' => 'I06'],
            ['regime_code' => '621', 'cfdi_use_code' => 'I06'],
            ['regime_code' => '622', 'cfdi_use_code' => 'I06'],
            ['regime_code' => '623', 'cfdi_use_code' => 'I06'],
            ['regime_code' => '624', 'cfdi_use_code' => 'I06'],
            ['regime_code' => '625', 'cfdi_use_code' => 'I06'],
            ['regime_code' => '626', 'cfdi_use_code' => 'I06'],

            // I07 – Comunicaciones satelitales
            ['regime_code' => '601', 'cfdi_use_code' => 'I07'],
            ['regime_code' => '603', 'cfdi_use_code' => 'I07'],
            ['regime_code' => '606', 'cfdi_use_code' => 'I07'],
            ['regime_code' => '612', 'cfdi_use_code' => 'I07'],
            ['regime_code' => '620', 'cfdi_use_code' => 'I07'],
            ['regime_code' => '621', 'cfdi_use_code' => 'I07'],
            ['regime_code' => '622', 'cfdi_use_code' => 'I07'],
            ['regime_code' => '623', 'cfdi_use_code' => 'I07'],
            ['regime_code' => '624', 'cfdi_use_code' => 'I07'],
            ['regime_code' => '625', 'cfdi_use_code' => 'I07'],
            ['regime_code' => '626', 'cfdi_use_code' => 'I07'],

            // I08 – Otra maquinaria y equipo
            ['regime_code' => '601', 'cfdi_use_code' => 'I08'],
            ['regime_code' => '603', 'cfdi_use_code' => 'I08'],
            ['regime_code' => '606', 'cfdi_use_code' => 'I08'],
            ['regime_code' => '612', 'cfdi_use_code' => 'I08'],
            ['regime_code' => '620', 'cfdi_use_code' => 'I08'],
            ['regime_code' => '621', 'cfdi_use_code' => 'I08'],
            ['regime_code' => '622', 'cfdi_use_code' => 'I08'],
            ['regime_code' => '623', 'cfdi_use_code' => 'I08'],
            ['regime_code' => '624', 'cfdi_use_code' => 'I08'],
            ['regime_code' => '625', 'cfdi_use_code' => 'I08'],
            ['regime_code' => '626', 'cfdi_use_code' => 'I08'],

            // D01 – Honorarios médicos, dentales y gastos hospitalarios
            ['regime_code' => '605', 'cfdi_use_code' => 'D01'],
            ['regime_code' => '606', 'cfdi_use_code' => 'D01'],
            ['regime_code' => '608', 'cfdi_use_code' => 'D01'],
            ['regime_code' => '611', 'cfdi_use_code' => 'D01'],
            ['regime_code' => '612', 'cfdi_use_code' => 'D01'],
            ['regime_code' => '614', 'cfdi_use_code' => 'D01'],
            ['regime_code' => '607', 'cfdi_use_code' => 'D01'],
            ['regime_code' => '615', 'cfdi_use_code' => 'D01'],
            ['regime_code' => '625', 'cfdi_use_code' => 'D01'],

            // D02 – Gastos médicos por incapacidad o discapacidad
            ['regime_code' => '605', 'cfdi_use_code' => 'D02'],
            ['regime_code' => '606', 'cfdi_use_code' => 'D02'],
            ['regime_code' => '608', 'cfdi_use_code' => 'D02'],
            ['regime_code' => '611', 'cfdi_use_code' => 'D02'],
            ['regime_code' => '612', 'cfdi_use_code' => 'D02'],
            ['regime_code' => '614', 'cfdi_use_code' => 'D02'],
            ['regime_code' => '607', 'cfdi_use_code' => 'D02'],
            ['regime_code' => '615', 'cfdi_use_code' => 'D02'],
            ['regime_code' => '625', 'cfdi_use_code' => 'D02'],

            // D03 – Gastos funerales
            ['regime_code' => '605', 'cfdi_use_code' => 'D03'],
            ['regime_code' => '606', 'cfdi_use_code' => 'D03'],
            ['regime_code' => '608', 'cfdi_use_code' => 'D03'],
            ['regime_code' => '611', 'cfdi_use_code' => 'D03'],
            ['regime_code' => '612', 'cfdi_use_code' => 'D03'],
            ['regime_code' => '614', 'cfdi_use_code' => 'D03'],
            ['regime_code' => '607', 'cfdi_use_code' => 'D03'],
            ['regime_code' => '615', 'cfdi_use_code' => 'D03'],
            ['regime_code' => '625', 'cfdi_use_code' => 'D03'],

            // D04 – Donativos
            ['regime_code' => '605', 'cfdi_use_code' => 'D04'],
            ['regime_code' => '606', 'cfdi_use_code' => 'D04'],
            ['regime_code' => '608', 'cfdi_use_code' => 'D04'],
            ['regime_code' => '611', 'cfdi_use_code' => 'D04'],
            ['regime_code' => '612', 'cfdi_use_code' => 'D04'],
            ['regime_code' => '614', 'cfdi_use_code' => 'D04'],
            ['regime_code' => '607', 'cfdi_use_code' => 'D04'],
            ['regime_code' => '615', 'cfdi_use_code' => 'D04'],
            ['regime_code' => '625', 'cfdi_use_code' => 'D04'],

            // D05 – Intereses reales efectivamente pagados por créditos hipotecarios
            ['regime_code' => '605', 'cfdi_use_code' => 'D05'],
            ['regime_code' => '606', 'cfdi_use_code' => 'D05'],
            ['regime_code' => '608', 'cfdi_use_code' => 'D05'],
            ['regime_code' => '611', 'cfdi_use_code' => 'D05'],
            ['regime_code' => '612', 'cfdi_use_code' => 'D05'],
            ['regime_code' => '614', 'cfdi_use_code' => 'D05'],
            ['regime_code' => '607', 'cfdi_use_code' => 'D05'],
            ['regime_code' => '615', 'cfdi_use_code' => 'D05'],
            ['regime_code' => '625', 'cfdi_use_code' => 'D05'],

            // D06 – Aportaciones voluntarias al SAR
            ['regime_code' => '605', 'cfdi_use_code' => 'D06'],
            ['regime_code' => '606', 'cfdi_use_code' => 'D06'],
            ['regime_code' => '608', 'cfdi_use_code' => 'D06'],
            ['regime_code' => '611', 'cfdi_use_code' => 'D06'],
            ['regime_code' => '612', 'cfdi_use_code' => 'D06'],
            ['regime_code' => '614', 'cfdi_use_code' => 'D06'],
            ['regime_code' => '607', 'cfdi_use_code' => 'D06'],
            ['regime_code' => '615', 'cfdi_use_code' => 'D06'],
            ['regime_code' => '625', 'cfdi_use_code' => 'D06'],

            // D07 – Primas por seguros de gastos médicos
            ['regime_code' => '605', 'cfdi_use_code' => 'D07'],
            ['regime_code' => '606', 'cfdi_use_code' => 'D07'],
            ['regime_code' => '608', 'cfdi_use_code' => 'D07'],
            ['regime_code' => '611', 'cfdi_use_code' => 'D07'],
            ['regime_code' => '612', 'cfdi_use_code' => 'D07'],
            ['regime_code' => '614', 'cfdi_use_code' => 'D07'],
            ['regime_code' => '607', 'cfdi_use_code' => 'D07'],
            ['regime_code' => '615', 'cfdi_use_code' => 'D07'],
            ['regime_code' => '625', 'cfdi_use_code' => 'D07'],

            // D08 – Gastos de transportación escolar obligatoria
            ['regime_code' => '605', 'cfdi_use_code' => 'D08'],
            ['regime_code' => '606', 'cfdi_use_code' => 'D08'],
            ['regime_code' => '608', 'cfdi_use_code' => 'D08'],
            ['regime_code' => '611', 'cfdi_use_code' => 'D08'],
            ['regime_code' => '612', 'cfdi_use_code' => 'D08'],
            ['regime_code' => '614', 'cfdi_use_code' => 'D08'],
            ['regime_code' => '607', 'cfdi_use_code' => 'D08'],
            ['regime_code' => '615', 'cfdi_use_code' => 'D08'],
            ['regime_code' => '625', 'cfdi_use_code' => 'D08'],

            // D09 – Depósitos en cuentas para el ahorro
            ['regime_code' => '605', 'cfdi_use_code' => 'D09'],
            ['regime_code' => '606', 'cfdi_use_code' => 'D09'],
            ['regime_code' => '608', 'cfdi_use_code' => 'D09'],
            ['regime_code' => '611', 'cfdi_use_code' => 'D09'],
            ['regime_code' => '612', 'cfdi_use_code' => 'D09'],
            ['regime_code' => '614', 'cfdi_use_code' => 'D09'],
            ['regime_code' => '607', 'cfdi_use_code' => 'D09'],
            ['regime_code' => '615', 'cfdi_use_code' => 'D09'],
            ['regime_code' => '625', 'cfdi_use_code' => 'D09'],

            // D10 – Pagos por servicios educativos
            ['regime_code' => '605', 'cfdi_use_code' => 'D10'],
            ['regime_code' => '606', 'cfdi_use_code' => 'D10'],
            ['regime_code' => '608', 'cfdi_use_code' => 'D10'],
            ['regime_code' => '611', 'cfdi_use_code' => 'D10'],
            ['regime_code' => '612', 'cfdi_use_code' => 'D10'],
            ['regime_code' => '614', 'cfdi_use_code' => 'D10'],
            ['regime_code' => '607', 'cfdi_use_code' => 'D10'],
            ['regime_code' => '615', 'cfdi_use_code' => 'D10'],
            ['regime_code' => '625', 'cfdi_use_code' => 'D10'],

            // S01 – Sin efectos fiscales
            ['regime_code' => '601', 'cfdi_use_code' => 'S01'],
            ['regime_code' => '603', 'cfdi_use_code' => 'S01'],
            ['regime_code' => '605', 'cfdi_use_code' => 'S01'],
            ['regime_code' => '606', 'cfdi_use_code' => 'S01'],
            ['regime_code' => '608', 'cfdi_use_code' => 'S01'],
            ['regime_code' => '610', 'cfdi_use_code' => 'S01'],
            ['regime_code' => '611', 'cfdi_use_code' => 'S01'],
            ['regime_code' => '612', 'cfdi_use_code' => 'S01'],
            ['regime_code' => '614', 'cfdi_use_code' => 'S01'],
            ['regime_code' => '616', 'cfdi_use_code' => 'S01'],
            ['regime_code' => '620', 'cfdi_use_code' => 'S01'],
            ['regime_code' => '621', 'cfdi_use_code' => 'S01'],
            ['regime_code' => '622', 'cfdi_use_code' => 'S01'],
            ['regime_code' => '623', 'cfdi_use_code' => 'S01'],
            ['regime_code' => '624', 'cfdi_use_code' => 'S01'],
            ['regime_code' => '625', 'cfdi_use_code' => 'S01'],
            ['regime_code' => '626', 'cfdi_use_code' => 'S01'],

            // CP01 – Pagos
            ['regime_code' => '601', 'cfdi_use_code' => 'CP01'],
            ['regime_code' => '603', 'cfdi_use_code' => 'CP01'],
            ['regime_code' => '605', 'cfdi_use_code' => 'CP01'],
            ['regime_code' => '606', 'cfdi_use_code' => 'CP01'],
            ['regime_code' => '608', 'cfdi_use_code' => 'CP01'],
            ['regime_code' => '610', 'cfdi_use_code' => 'CP01'],
            ['regime_code' => '611', 'cfdi_use_code' => 'CP01'],
            ['regime_code' => '612', 'cfdi_use_code' => 'CP01'],
            ['regime_code' => '614', 'cfdi_use_code' => 'CP01'],
            ['regime_code' => '616', 'cfdi_use_code' => 'CP01'],
            ['regime_code' => '620', 'cfdi_use_code' => 'CP01'],
            ['regime_code' => '621', 'cfdi_use_code' => 'CP01'],
            ['regime_code' => '622', 'cfdi_use_code' => 'CP01'],
            ['regime_code' => '623', 'cfdi_use_code' => 'CP01'],
            ['regime_code' => '624', 'cfdi_use_code' => 'CP01'],
            ['regime_code' => '625', 'cfdi_use_code' => 'CP01'],
            ['regime_code' => '626', 'cfdi_use_code' => 'CP01'],

            // CN01 – Nómina
            ['regime_code' => '605', 'cfdi_use_code' => 'CN01'],
        ];

        // Filtrar solo los registros válidos (que existen en ambas tablas)
        $validData = collect($data)->filter(function ($item) {
            $regimeExists = SatRegime::where('code', $item['regime_code'])->exists();
            $cfdiUseExists = SatCfdiUse::where('code', $item['cfdi_use_code'])->exists();

            if (!$regimeExists) {
                $this->command->warn("⚠️  Régimen '{$item['regime_code']}' no existe en sat_regimes");
            }
            if (!$cfdiUseExists) {
                $this->command->warn("⚠️  Uso CFDI '{$item['cfdi_use_code']}' no existe en sat_cfdi_uses");
            }

            return $regimeExists && $cfdiUseExists;
        })->toArray();

        if (count($validData) > 0) {
            SatRegimeCfdiUse::insert($validData);
            $this->command->info("✅ Se insertaron " . count($validData) . " relaciones régimen-cfdi correctamente.");
        } else {
            $this->command->error("❌ No hay datos válidos para insertar. Verifica que existan los códigos de régimen y uso de CFDI.");
        }

        $skipped = count($data) - count($validData);
        if ($skipped > 0) {
            $this->command->warn("⚠️  Se omitieron {$skipped} registros por códigos inexistentes.");
        }
    }
}
