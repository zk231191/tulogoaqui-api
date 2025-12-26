<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Redis;
use Symfony\Component\HttpFoundation\StreamedResponse;

class StreamController extends Controller
{
    public function stream(): StreamedResponse
    {
        set_time_limit(0);
        ignore_user_abort(true);

        return response()->stream(function () {

            // handshake SSE
            echo ": connected\n\n";
            echo "retry: 5000\n\n";
            flush();

            // escucha Redis (BLOQUEANTE)
            Redis::subscribe(['sse.orders'], function ($message) {

                $payload = json_decode($message, true);

                echo "event: {$payload['type']}\n";
                echo "data: " . json_encode($payload['data']) . "\n\n";

                flush();
            });

        }, 200, [
            'Content-Type' => 'text/event-stream',
            'Cache-Control' => 'no-cache',
            'Connection' => 'keep-alive',
            'X-Accel-Buffering' => 'no',
            'Access-Control-Allow-Origin' => 'http://localhost:5173',
        ]);
    }


}
