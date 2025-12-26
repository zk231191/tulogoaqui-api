<?php

namespace App\Http\Controllers;

use App\Actions\FiscalAddress\Create;
use App\Http\Requests\FiscalAddress\CreateRequest;
use App\Models\FiscalAddress;
use Illuminate\Http\Request;

class FiscalAddressesController extends Controller
{
    public function store(CreateRequest $request, Create $action): FiscalAddress
    {
        return $action->handle($request->validated());
    }
}
