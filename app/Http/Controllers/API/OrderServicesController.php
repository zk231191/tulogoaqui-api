<?php

namespace App\Http\Controllers\Api;

use App\Events\Orders\OrderUpdated;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrderService\UpdateStatusRequest;
use App\Models\Order;
use App\Models\OrderService;
use App\Models\OrderServiceItem;
use App\Models\OrderServiceStatus;
use App\Models\OrderServiceSubstatus;
use Illuminate\Http\Request;

class OrderServicesController extends Controller
{
    public function statuses(): \Illuminate\Http\JsonResponse
    {
        $status = OrderServiceStatus::with('substatus')->get();

        return response()->json($status);
    }

    public function substatuses(): \Illuminate\Http\JsonResponse
    {
        $substatus = OrderServiceSubstatus::all();

        return response()->json($substatus);
    }

    public function updateStatus(OrderService $orderService, UpdateStatusRequest $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->validated();

        $orderService->update([
            'order_service_status_id' => $data['status_id'],
        ]);

        $orderService->refresh()
            ->load((new OrderService)->withRelations());

        $order = Order::find($orderService->order_id);

        event(new OrderUpdated($order));

        return response()->json($orderService);
    }

    public function updateSubstatus(OrderServiceItem $orderServiceItem, UpdateStatusRequest $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->validated();
        $orderServiceItem->update([
            'order_service_substatus_id' => $data['status_id'],
        ]);

        $orderServiceItem->refresh()
            ->load('orderService');

        $order = Order::find($orderServiceItem->orderService->order_id);

        event(new OrderUpdated($order));

        return response()->json($orderServiceItem);
    }
}
