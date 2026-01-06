<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\PaymentMethod;
use Illuminate\Http\Request;

class PaymentsController extends Controller
{
    public function methods(): \Illuminate\Database\Eloquent\Collection
    {
        return PaymentMethod::all();
    }
}
