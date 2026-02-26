<?php

namespace App\Services\Billing;

use App\Services\Billing\Contracts\BillingProviderInterface;
use App\Services\Billing\Providers\DetecnoProvider;
use App\Services\Billing\Providers\FacturamaProvider;

class BillingManager
{
    protected BillingProviderInterface $provider;

    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        $driver = config('billing.driver');

        $this->provider = match ($driver) {
            'facturama' => app(FacturamaProvider::class),
            'detecno' => app(DetecnoProvider::class)
        };
    }

    public function create(array $data)
    {
        return $this->provider->create($data);
    }

    public function cancel(string $uuid)
    {
        return $this->provider->cancel($uuid);
    }
}
