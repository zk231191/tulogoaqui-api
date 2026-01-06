<?php

namespace App\Http\Controllers\Api;

use App\Events\Orders\OrderUpdated;
use App\Http\Controllers\Controller;
use App\Http\Requests\OrderPayments\StorePaymentRequest;
use App\Models\Order;
use Illuminate\Support\Facades\DB;

class OrderPaymentsController extends Controller
{
    public function store(Order $order, StorePaymentRequest $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->validated();

        DB::transaction(function () use ($order, $data) {
            $order->payments()->create([
                'order_id' => $order->id,
                'amount' => $data['amount'],
                'payment_method_id' => $data['method_id'],
                'reference' => $data['reference'],
            ]);

            $order->pending_amount -= $data['amount'];
            $order->paid_amount += $data['amount'];
            $order->save();
        });

        $order->load(['payments']);

        event(new OrderUpdated($order));

        return response()->json($order);
    }
}
