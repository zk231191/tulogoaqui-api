<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Reports\SellersRequest;
use App\Models\Order;
use Illuminate\Http\Request;

class ReportsController extends Controller
{
    public function sellers(SellersRequest $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->validated();
        $data['start'] = '2025-01-01';

        $orders = Order::query()
            ->selectRaw('seller_id, COUNT(*) as total_orders, SUM(total) as total_sales')
            ->whereBetween('created_at', [$data['start'], $data['end']])
            ->groupBy('seller_id')
            ->with('seller:id,name') // solo los campos que necesitas
            ->get();

        return response()->json($orders);
    }
}
