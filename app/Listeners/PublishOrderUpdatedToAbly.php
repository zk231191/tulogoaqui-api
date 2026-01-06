<?php

namespace App\Listeners;

use App\Events\Orders\OrderUpdated;
use App\Services\AblyService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;

class PublishOrderUpdatedToAbly
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(OrderUpdated $event): void
    {
        app(AblyService::class)->publish(
            'orders',
            'order-updated',
            $event->order->toArray()
        );
    }
}
