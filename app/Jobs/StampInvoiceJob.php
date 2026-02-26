<?php

namespace App\Jobs;

use App\Models\Order;
use App\Services\Billing\BillingManager;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Queue\InteractsWithQueue;

class StampInvoiceJob implements ShouldQueue
{
    use Queueable, Dispatchable, InteractsWithQueue, SerializesModels;

    public $tires = 5;

    public $backoff = [60, 300, 600];

    public function __construct()
    {
        //
    }

    /**
     * Execute the job.
     */
    public function handle(BillingManager $billing): void
    {
        $order = $this->order->fresh()->load('invoice', 'fiscalAddress');

        if (!$order->invoice) {
            return;
        }

        if ($order->invoice->status === 'stamped') {
            return;
        }

        try {
            $payload = $this->buildPayload($order);

            $response = $billing->create($payload);

            $order->invoice->update([
                'provider' => config('billing.driver'),
                'external_id' => $response['Id'] ?? null,
                'uuid' => $response['Complement']['TaxStamp']['Uuid'] ?? null,
                'status' => 'stamped',
                'error_message' => null,
            ]);
        } catch (\Throwable $e) {
            $order->invoice->update([
                'status' => 'error',
                'error_message' => $e->getMessage(),
            ]);

            throw $e;
        }
    }

    protected function buildPayload(Order $order): array
    {
        $receiver = $order->fiscalAddress;

        return [
            "CfdiType" => "I",
            "ExpeditionPlace" => config('company.zip_code'),

            "Receiver" => [
                "Rfc" => $receiver->rfc,
                "Name" => $receiver->business_name,
                "CfdiUse" => $order->cfdi_use_code,
                "FiscalRegime" => $receiver->tax_regime_code,
                "TaxZipCode" => $receiver->zip_code,
            ],

            "Items" => [
                [
                    "ProductCode" => "01010101",
                    "Description" => "Servicios contratados",
                    "Unit" => "E48",
                    "UnitCode" => "E48",
                    "UnitPrice" => $order->subtotal,
                    "Quantity" => 1,
                    "Subtotal" => $order->subtotal,
                    "TaxObject" => "02",

                    "Taxes" => [
                        [
                            "Name" => "IVA",
                            "Rate" => 0.16,
                            "Base" => $order->subtotal,
                            "Total" => $order->tax,
                            "IsRetention" => false
                        ]
                    ]
                ]
            ]
        ];
    }
}
