<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\OrderServiceStatus;
use Illuminate\Http\Request;

class OrderServiceStatusesController extends Controller
{
    public function index(): \Illuminate\Http\JsonResponse
    {
        $status = OrderServiceStatus::with('substatus')->get();

        return response()->json($status);
    }
}
