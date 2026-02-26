<?php

namespace App\Providers;

use App\Events\Orders\OrderCreated;
use App\Listeners\PublishOrderCreatedToAbly;
use Illuminate\Support\ServiceProvider;

class EventServiceProvider extends ServiceProvider
{
    protected $listen = [
        OrderCreated::class => [
            PublishOrderCreatedToAbly::class
        ],
        \App\Events\Orders\OrderUpdated::class => [
            \App\Listeners\StampInvoiceListener::class
        ]
    ];
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        //
    }
}
