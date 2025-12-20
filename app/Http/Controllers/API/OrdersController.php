<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Order\StoreOrderRequest;
use App\Models\Order;
use App\Models\OrderPayment;
use App\Models\OrderService;
use App\Models\OrderServiceItem;
use Illuminate\Support\Facades\DB;

class OrdersController extends Controller
{
    public function index()
    {
        return Order::all();
    }

    public function store(StoreOrderRequest $request)
    {
        return DB::transaction(function () use ($request) {

            if ($request->requires_invoce) {
                if (!$request->fiscal_address_id) {
                    
                }
            }

            /* =====================
             * ORDER
             * ===================== */
            $order = Order::create([
                'seller_id' => auth()->id(),
                'customer_id' => $request->customer_id,
                'fiscal_address_id' => $request->fiscal_address_id,
                'require_invoice' => $request->requires_invoice,
                'cfdi_use_id' => $request->cfdi_use,
                'comments' => $request->notes,
                'discount' => $request->discount ?? 0,
            ]);

            /* =====================
             * SERVICES
             * ===================== */

            foreach ($request->items as $item) {

                $orderService = OrderService::create([
                    'order_id' => $order->id,
                    'service_id' => $item['service_id'],
                    'mode_id' => $item['mode_id'],
                    'order_status_id' => 1, // inicial
                    'quantity' => $item['quantity'],
                ]);

                foreach ($item['price_id'] as $priceId) {

                    $price = \App\Models\ServicePriceTier::findOrFail($priceId);

                    OrderServiceItem::create([
                        'order_service_id' => $orderService->id,
                        'service_mode_price_id' => $price->id,
                        'order_substatus_id' => 1,
                        'quantity' => $item['quantity'],
                        'unit_price' => $price->price,
                        'total' => $price->price * $item['quantity'],
                    ]);
                }
            }

            /* =====================
             * ANTICIPO
             * ===================== */

            if ($request->deposit > 0) {
                OrderPayment::create([
                    'order_id' => $order->id,
                    'payment_method_id' => 1, // efectivo por default
                    'amount' => $request->deposit,
                ]);
            }

            return response()->json(
                $order->load('services.items'),
                201
            );
        });
    }
}
