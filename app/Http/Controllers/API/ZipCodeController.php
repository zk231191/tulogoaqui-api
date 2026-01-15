<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Services\DipomexService;
use Illuminate\Http\Request;

class ZipCodeController extends Controller
{
    public function show(string $zip)
    {
        if (strlen($zip) !== 5) {
            return response()->json([
                'message' => 'Código postal inválido',
            ], 422);
        }

        try {
            $data = app(DipomexService::class)->byZip($zip);
            return response()->json($data);
        } catch (\Throwable $e) {
            return response()->json([
                'message' => $e->getMessage(),
            ], 404);
        }
    }
}
