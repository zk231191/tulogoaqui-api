<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Redis;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\StreamedResponse;

class SseController extends Controller
{
    public function events(): StreamedResponse
    {
        return response()->stream(function () {
            while (!connection_aborted()) {
                $event = Redis::get('sse:last_event');

                if ($event) {
                    $payload = json_decode($event, true);

                    echo "event: {$payload['event']}\n";
                    echo "data: " . json_encode($payload['data']) . "\n\n";
                    flush();
                }

                echo ": heartbeat\n\n";
                flush();
                sleep(3);
            }
        }, 200, [
            'Content-Type' => 'text/event-stream',
            'Cache-Control' => 'no-cache',
            'X-Accel-Buffering' => 'no',
        ]);
    }

    // Endpoint de prueba con publicación a Redis
    public function testPublish(Request $request)
    {
        try {
            $message = $request->input('message', 'Test message from ' . now()->format('H:i:s'));

            $data = json_encode([
                'message' => $message,
                'timestamp' => now()->toISOString(),
                'random' => rand(1, 100)
            ]);

            // Publicar en Redis
            $result = Redis::publish('public-channel', $data);

            return response()->json([
                'success' => true,
                'message' => 'Message published to Redis',
                'subscribers' => $result,
                'data' => json_decode($data)
            ]);
        } catch (\Exception $e) {
            Log::error('SSE: Error al publicar', ['error' => $e->getMessage()]);

            return response()->json([
                'success' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }

    // Endpoint para verificar el estado de Redis
    public function status()
    {
        try {
            $ping = Redis::ping();
            $info = Redis::info();

            return response()->json([
                'redis_connected' => $ping === 'PONG',
                'redis_info' => [
                    'version' => $info['redis_version'] ?? 'unknown',
                    'connected_clients' => $info['connected_clients'] ?? 0,
                    'used_memory_human' => $info['used_memory_human'] ?? 'unknown'
                ]
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'redis_connected' => false,
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
