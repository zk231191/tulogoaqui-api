<?php
namespace App\Services;

use Illuminate\Support\Facades\Http;

class DipomexService
{
    private $url = "https://api.tau.com.mx/dipomex/v1/";
    public function byZip(string $zipCode): array
    {
        $response = Http::withHeaders([
            'APIKEY' => config('services.dipomex.key'),
        ])->get(
            $this->url.'codigo_postal',
            ['cp' => $zipCode]
        );

        if (!$response->successful()) {
            throw new \Exception('Código postal no encontrado');
        }

        return $response->json('codigo_postal');
    }
}
