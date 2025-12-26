<?php

namespace App\Listeners;

use App\Events\Orders\OrderCreated;
use App\Services\AblyService;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Support\Facades\Log;

class PublishOrderCreatedToAbly
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
    public function handle(OrderCreated $event): void
    {
        app(AblyService::class)->publish(
            'orders',
            'order-created',
            $event->order->toArray()
        );
    }
}
