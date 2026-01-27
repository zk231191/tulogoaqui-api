<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\DipomexService;
use Illuminate\Http\Request;

class ZipCodeController extends Controller
{
    private $dipomexEstates = [
        "AGUASCALIENTES" => "Aguascalientes",
        "BAJA CALIFORNIA" => "Baja California",
        "BAJA CALIFORNIA SUR" => "Baja California Sur",
        "CAMPECHE" => "Campeche",
        "CHIAPAS" => "Chiapas",
        "CHIHUAHUA" => "Chihuahua",
        "CIUDAD DE MEXICO" => "Ciudad de Mexico",
        "COAHUILA DE ZARAGOZA" => "Coahuila",
        "COLIMA" => "Colima",
        "DURANGO" => "Durango",
        "GUANAJUATO" => "Guanajuato",
        "GUERRERO" => "Guerrero",
        "HIDALGO" => "Hidalgo",
        "JALISCO" => "Jalisco",
        "MEXICO" => "Estado de Mexico",
        "MICHOACAN DE OCAMPO" => "Michoacan",
        "MORELOS" => "Morelos",
        "NAYARIT" => "Nayarit",
        "NUEVO LEON" => "Nuevo León",
        "OAXACA" => "Oaxaca",
        "PUEBLA" => "Puebla",
        "QUERETARO" => "Queretaro",
        "QUINTANA ROO" => "Quintana Roo",
        "SAN LUIS POTOSI" => "San Luis Potosi",
        "SINALOA" => "Sinaloa",
        "SONORA" => "Sonora",
        "TABASCO" => "Tabasco",
        "TAMAULIPAS" => "Tamaulipas",
        "TLAXCALA" => "Tlaxcala",
        "VERACRUZ DE LA LLAVE" => "Veracruz",
        "YUCATAN" => "Yucatan",
        "ZACATECAS" => "Zacatecas",
    ];

    public function show(string $zip)
    {
        if (strlen($zip) !== 5) {
            return response()->json([
                'message' => 'Código postal inválido',
            ], 422);
        }

        try {
            $data = app(DipomexService::class)->byZip($zip);

            $this->convertEstate($data);

            return response()->json($data);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 404);
        }
    }

    public function convertEstate(&$data): void
    {
        $data['estado'] = $this->dipomexEstates[$data['estado']];
    }
}
