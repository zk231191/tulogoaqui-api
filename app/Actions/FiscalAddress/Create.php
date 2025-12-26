<?php

namespace App\Actions\FiscalAddress;

use App\Models\FiscalAddress;

class Create
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function handle(array $data): FiscalAddress
    {
        return FiscalAddress::create($data);
    }
}
