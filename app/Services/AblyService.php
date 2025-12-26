<?php

namespace App\Services;

use Ably\AblyRest;
use Illuminate\Support\Facades\Log;

class AblyService
{
    protected AblyRest $ably;
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        $this->ably = new AblyRest(config('services.ably.key'));
    }

    public function publish(string $channel, string $event, $data = []): void
    {
        $this->ably->channels->get($channel)->publish($event, $data);
    }
}
