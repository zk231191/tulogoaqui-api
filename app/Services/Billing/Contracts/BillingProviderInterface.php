<?php

namespace App\Services\Billing\Contracts;

interface BillingProviderInterface
{
    public function create(array $data): array;

    public function cancel(string $uuid): array;

    public function get(string $uuid): array;
}
