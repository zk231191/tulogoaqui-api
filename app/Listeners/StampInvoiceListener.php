<?php

namespace App\Listeners;

use App\Events\Orders\OrderUpdated;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class StampInvoiceListener
{
    /**
     * Handle the event.
     */
    public function handle(OrderUpdated $event): void
    {
        $order = $event->order;

        if (
            $order->require_invoice &&
            $order->pending_amount == 0 &&
            !$order->invoice
        ) {
            $order->invoice()->create([
                'provider' => config('billing.driver'),
                'status' => 'pending'
            ]);

            StampInvoiceJob::dispatch($order);
        }
    }
}
