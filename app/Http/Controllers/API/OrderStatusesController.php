<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\OrderStatus;
use Illuminate\Http\Request;

class OrderStatusesController extends Controller
{
    public function index(): \Illuminate\Http\JsonResponse
    {
        $orderStatuses = OrderStatus::all();

        return response()->json($orderStatuses);
    }
}
