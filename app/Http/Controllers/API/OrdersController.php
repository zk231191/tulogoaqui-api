<?php

namespace App\Http\Controllers\Api;

use App\Actions\FiscalAddress\Create;
use App\Events\Orders\OrderCreated;
use App\Events\Orders\OrderUpdated;
use App\Http\Controllers\Controller;
use App\Http\Requests\Order\StoreOrderRequest;
use App\Http\Requests\Order\UpdateStatusRequest;
use App\Models\Order;
use App\Models\OrderPayment;
use App\Models\OrderService;
use App\Models\OrderServiceItem;
use App\Models\ServicePriceTier;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Str;

class OrdersController extends Controller
{
    public function index(): \Illuminate\Database\Eloquent\Collection
    {
        return Order::all();
    }

    public function store(StoreOrderRequest $request)
    {
        return DB::transaction(function () use ($request) {

            /* =====================
             * FISCAL ADDRESS
             * ===================== */
            $fiscalAddressId = null;

            if ($request->requires_invoice && !$request->fiscal_address_id) {
                $data = array_merge(
                    $request->billing_data ?? [],
                    [
                        'customer_id' => $request->customer['id'],
                        'cfdi_use_id' => $request->cfdi_use,
                        'tax_regime_id' => $request->billing_data['tax_regime'],
                    ]
                );

                $fiscalAddress = app(Create::class)->handle($data);
                $fiscalAddressId = $fiscalAddress->id;
            } else {
                $fiscalAddressId = $request->fiscal_address_id;
            }

            /* =====================
             * ORDER (BASE)
             * ===================== */
            $order = Order::create([
                'public_token' => Str::uuid(),
                'seller_id' => auth()->id(),
                'customer_id' => $request->customer['id'],
                'order_status_id' => 1,
                'fiscal_address_id' => $fiscalAddressId,
                'require_invoice' => $request->requires_invoice,
                'cfdi_use_code' => $request->cfdi_use,
                'comments' => $request->notes,
                'discount' => $request->discount ?? 0,

                'subtotal' => 0,
                'tax' => 0,
                'total' => 0,
                'paid_amount' => 0,
                'pending_amount' => 0,
            ]);

            /* =====================
             * CALCULOS
             * ===================== */
            $subtotal = 0;

            foreach ($request->items as $item) {

                $orderService = OrderService::create([
                    'order_id' => $order->id,
                    'service_id' => $item['service_id'],
                    'service_mode_id' => $item['mode_id'],
                    'order_service_status_id' => 1, // inicial
                    'quantity' => $item['quantity'],
                ]);

                foreach ($item['price_id'] as $priceId) {
                    $price = ServicePriceTier::findOrFail($priceId);

                    $lineSubtotal = $price->price * $item['quantity'];
                    $subtotal += $lineSubtotal;

                    OrderServiceItem::create([
                        'order_service_id' => $orderService->id,
                        'service_mode_price_id' => $price->id,
                        'order_service_substatus_id' => 1,
                        'quantity' => $item['quantity'],
                        'unit_price' => $price->price,
                        'subtotal' => $lineSubtotal,
                        'total' => $lineSubtotal,
                    ]);
                }
            }

            /* =====================
             * TOTALES
             * ===================== */
            $discount = $request->discount ?? 0;
            $tax = round($subtotal * 0.16, 2); // IVA 16%
            $total = max(($subtotal - $discount) + $tax, 0);

            /* =====================
             * PAGOS
             * ===================== */
            $paidAmount = 0;

            if ($request->deposit > 0) {
                OrderPayment::create([
                    'order_id' => $order->id,
                    'payment_method_id' => 1, // efectivo
                    'amount' => $request->deposit,
                ]);

                $paidAmount = $request->deposit;
            }

            $pendingAmount = max($total - $paidAmount, 0);

            /* =====================
             * UPDATE FINAL
             * ===================== */
            $order->update([
                'subtotal' => $subtotal,
                'tax' => $tax,
                'discount' => $discount,
                'total' => $total,
                'paid_amount' => $paidAmount,
                'pending_amount' => $pendingAmount,
            ]);

            $order = Order::findOrFail($order->id);

            event(new OrderCreated($order));

            return response()->json($order, 201);
        });
    }

    public function showPublic($token)
    {
        return Order::where('public_token', $token)->first();
    }

    public function show(Order $order): Order
    {
        return $order;
    }

    public function updateStatus(Order $order, UpdateStatusRequest $request): \Illuminate\Http\JsonResponse
    {
        $data = $request->validated();
        $order->update([
            'order_status_id' => $data['status_id'],
        ]);

        event(new OrderUpdated($order));

        return response()->json($order);
    }
}
