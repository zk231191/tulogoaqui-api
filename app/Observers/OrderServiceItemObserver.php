<?php

namespace App\Observers;

use App\Models\OrderServiceItem;
use App\Models\OrderStatusLog;

class OrderServiceItemObserver
{
    public function updated(OrderServiceItem $item)
    {
        // Verificar si cambió el substatus
        if ($item->isDirty('order_substatus_id')) {
            $orderService = $item->orderService;

            OrderStatusLog::create([
                'order_id' => $orderService->order_id,
                'order_service_id' => $orderService->id,
                'from_status_id' => $orderService->order_status_id,
                'to_status_id' => $orderService->order_status_id,
                'from_substatus_id' => $item->getOriginal('order_substatus_id'),
                'to_substatus_id' => $item->order_substatus_id,
                'user_id' => auth()->id(),
                'comment' => null,
            ]);
        }
    }
}
