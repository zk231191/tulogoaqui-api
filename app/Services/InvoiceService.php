<?php

namespace App\Services;

use App\Models\Invoice;
use App\Models\Order;
use App\Services\Cfdi\Cfdi40Builder;

class InvoiceService
{
    /**
     * Create a new class instance.
     */
    public function generate(Order $order)
    {
        if (!$order->require_invoice) {
            throw new \Exception('Order dos not  require invoice');
        }

        $builder = new Cfdi40Builder();
        $cfdiXml = $builder->build($order);

        $detecno = app(DetecnoCfdiService::class);

        $response = $detecno->generar40($cfdiXml);

        dd($response);

        $invoiceId = $response['FacturaId'] ?? null;

        if (!$invoiceId) {
            throw new \Exception('Error sending CFDI');
        }

        sleep(2);

        $result = $detecno->buscar40($invoiceId);

        if (($result['EstatusId'] ?? null) != 4) {
            throw new \Exception('CFDI not stamped.');
        }

        return Invoice::create([
            'order_id' => $order->id,
            'factura_id' => $invoiceId,
            'uuid' => $result['Uuid'],
            'xml' => $result['Xml'],
            'status' => 'stamped'
        ]);
    }
}
