<?php

namespace App\Observers;

use App\Models\OrderService;
use App\Models\OrderStatusLog;

class OrderServiceObserver
{
    public function updated(OrderService $orderService)
    {
        // Verificar si cambió el status o substatus
        if ($orderService->isDirty('order_status_id') || $orderService->isDirty('order_substatus_id')) {
            OrderStatusLog::create([
                'order_id' => $orderService->order_id,
                'order_service_id' => $orderService->id,
                'from_status_id' => $orderService->getOriginal('order_status_id'),
                'to_status_id' => $orderService->order_status_id,
                'from_substatus_id' => $orderService->getOriginal('order_substatus_id') ?? $orderService->getOriginal('order_status_id'),
                'to_substatus_id' => $orderService->order_substatus_id ?? $orderService->order_status_id,
                'user_id' => auth()->id(),
                'comment' => null,
            ]);
        }
    }
}
