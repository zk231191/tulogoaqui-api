<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\FiscalAddress\UpdateRequest;
use App\Models\Customer;
use App\Models\FiscalAddress;
use Illuminate\Http\Request;

class FiscalAddressesController extends Controller
{
    public function update(Customer $customer, FiscalAddress $fiscalAddress, UpdateRequest $request): FiscalAddress
    {
        $fiscalAddress->update($request->validated());

        return $fiscalAddress;
    }

    public function destroy(Customer $customer, FiscalAddress $fiscalAddress)
    {
        $fiscalAddress->delete();

        return response(null, 204);
    }
}
