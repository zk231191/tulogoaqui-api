<?php

namespace App\Http\Controllers;

use App\Actions\FiscalAddress\Create;
use App\Http\Requests\FiscalAddress\CreateRequest;
use App\Http\Requests\FiscalAddress\UpdateRequest;
use App\Models\FiscalAddress;

class FiscalAddressesController extends Controller
{
    public function store(CreateRequest $request, Create $action): FiscalAddress
    {
        return $action->handle($request->validated());
    }
}
