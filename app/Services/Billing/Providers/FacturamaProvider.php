<?php

namespace App\Services\Billing\Providers;

use App\Services\Billing\Contracts\BillingProviderInterface;
use Illuminate\Support\Facades\Http;

class FacturamaProvider implements BillingProviderInterface
{
    protected string $baseUrl;
    protected string $username;
    protected string $password;

    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        $this->baseUrl = config('services.facturama.url');
        $this->username = config('services.facturama.username');
        $this->password = config('services.facturama.password');
    }

    protected function client()
    {
        return Http::withBasicAuth($this->username, $this->password)
            ->baseUrl($this->baseUrl)
            ->acceptJson();
    }

    public function create(array $data): array
    {
        $response = $this->client()->post("/3/cfdis", $data);

        if (!$response->successful()) {
            throw new \Exception(
                "Facturama error creating invoice ({$response->status()}): " . $response->body()
            );
        }

        return $response->json();
    }

    public function cancel(string $uuid): array
    {
        $response = $this->client()->post("/3/cfdis/{$uuid}/cancel");

        if (!$response->successful()) {
            throw new \Exception(
                "Error cannot cancel invoice => ({$response->status()}): " . $response->body()
            );
        }

        return $response->json();
    }

    public function get(string $uuid): array
    {
        return $this->client()->get("/3/cfdis/{$uuid}")->json();
    }
}
