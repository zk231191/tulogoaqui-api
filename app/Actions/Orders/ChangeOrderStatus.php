<?php
namespace App\Actions\Orders;

use App\Models\Order;
use App\Models\OrderService;
use App\Models\OrderStatusLog;
use Illuminate\Support\Facades\DB;

class ChangeOrderStatus
{
    public function handle(
        Order $order,
        int $toStatusId,
        int $toSubstatusId,
        ?OrderService $orderService = null,
        ?string $comment = null
    ): void {
        DB::transaction(function () use (
            $order,
            $toStatusId,
            $toSubstatusId,
            $orderService,
            $comment
        ) {
            $fromStatusId = $order->order_service_status_id;
            $fromSubstatusId = $order->order_service_substatus_id;

            $order->update([
                'order_service_status_id' => $toStatusId,
                'order_service_substatus_id' => $toSubstatusId,
            ]);

            OrderStatusLog::create([
                'order_id' => $order->id,
                'order_service_id' => $orderService?->id,
                'from_order_service_status_id' => $fromStatusId,
                'to_order_service_status_id' => $toStatusId,
                'from_order_service_substatus_id' => $fromSubstatusId,
                'to_order_service_substatus_id' => $toSubstatusId,
                'user_id' => auth()->id(),
                'comment' => $comment,
            ]);
        });
    }
}
