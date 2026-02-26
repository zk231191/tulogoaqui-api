<?php

namespace App\Services\Cfdi;

use App\Models\Order;
use DOMDocument;
use DOMNode;

class Cfdi40Builder
{
    /**
     * Create a new class instance.
     */
    public function __construct()
    {
        //
    }

    public function build(Order $order): string
    {
        $order->load('services.items', 'fiscalAddress.regime');

        $doc = new \DOMDocument('1.0', 'UTF-8');
        $doc->formatOutput = false;

        $comprobante = $doc->createElementNS(
            'http://www.sat.gob.mx/cfd/4',
            'cfdi:Comprobante'
        );

        $doc->appendChild($comprobante);

        $comprobante->setAttribute('Version', '4.0');
        $comprobante->setAttribute('Serie', 'A');
        $comprobante->setAttribute('Folio', $order->id);
        $comprobante->setAttribute('Fecha', now()->format('Y-m-d\TH:i:s'));
        $comprobante->setAttribute('Moneda', 'MXN');
        $comprobante->setAttribute('TipoDeComprobante', 'I');
        $comprobante->setAttribute('MetodoPago', 'PUE');
        $comprobante->setAttribute('FormaPago', '01');
        $comprobante->setAttribute('LugarExpedicion', config('cfdi.demo.zip'));

        $comprobante->setAttribute('SubTotal', number_format($order->subtotal, 2, '.', ''));
        $comprobante->setAttribute('Total', number_format($order->total, 2, '.', ''));

        $this->appendEmisor($doc, $comprobante);
        $this->appendReceptor($doc, $comprobante, $order);
        $this->appendConceptos($doc, $comprobante, $order);
        $this->appendImpuestosGlobal($doc, $comprobante, $order);

        return $doc->saveXML();
    }

    private function appendEmisor(DOMDocument $doc, \DOMElement $parent)
    {
        $emisor = $doc->createElement('cfdi:Emisor');

        $config = config('cfdi.' . config('cfdi.mode'));

        $emisor->setAttribute('Rfc', $config['rfc']);
        $emisor->setAttribute('Nombre', $config['name']);
        $emisor->setAttribute('RegimenFiscal', $config['regimen']);

        $parent->appendChild($emisor);
    }

    private function appendReceptor(DOMDocument $doc, \DOMElement $parent, Order $order)
    {
        $fiscal = $order->fiscalAddress;

        $receptor = $doc->createElement('cfdi:Receptor');

        $receptor->setAttribute('Rfc', $fiscal->tax_identification_number);
        $receptor->setAttribute('Nombre', $fiscal->business_name);
        $receptor->setAttribute('DomicilioFiscalReceptor', $fiscal->zip_code);
        $receptor->setAttribute('RegimenFiscalReceptor', $fiscal->regime->code);
        $receptor->setAttribute('UsoCFDI', $fiscal->cfdi_use_code ?? 'G03');

        $parent->appendChild($receptor);
    }

    private function appendConceptos(DOMDocument $doc, \DOMElement $parent, Order $order)
    {
        $conceptos = $doc->createElement('cfdi:Conceptos');

        $subtotal = $order->subtotal;
        $ivaTotal = $order->tax;

        $ivaAcumulado = 0;
        $items = $order->services->flatMap->items;

        foreach ($items as $index => $item) {

            $concepto = $doc->createElement('cfdi:Concepto');

            $importe = $item->subtotal;
            $proporcion = $importe / $subtotal;
            $ivaItem = round($ivaTotal * $proporcion, 2);

            if ($index === $items->count() - 1) {
                $ivaItem = $ivaTotal - $ivaAcumulado;
            }

            $ivaAcumulado += $ivaItem;

            $concepto->setAttribute('ClaveProdServ', '01010101');
            $concepto->setAttribute('Cantidad', $item->quantity);
            $concepto->setAttribute('ClaveUnidad', 'H87');
            $concepto->setAttribute('Descripcion', 'Servicio');
            $concepto->setAttribute('ValorUnitario', number_format($item->unit_price, 2, '.', ''));
            $concepto->setAttribute('Importe', number_format($importe, 2, '.', ''));
            $concepto->setAttribute('ObjetoImp', '02');

            $impuestos = $doc->createElement('cfdi:Impuestos');
            $traslados = $doc->createElement('cfdi:Traslados');
            $traslado = $doc->createElement('cfdi:Traslado');

            $traslado->setAttribute('Base', number_format($importe, 2, '.', ''));
            $traslado->setAttribute('Impuesto', '002');
            $traslado->setAttribute('TipoFactor', 'Tasa');
            $traslado->setAttribute('TasaOCuota', '0.160000');
            $traslado->setAttribute('Importe', number_format($ivaItem, 2, '.', ''));

            $traslados->appendChild($traslado);
            $impuestos->appendChild($traslados);
            $concepto->appendChild($impuestos);

            $conceptos->appendChild($concepto);
        }

        $parent->appendChild($conceptos);
    }

    private function appendImpuestosGlobal(DOMDocument $doc, \DOMElement $parent, Order $order)
    {
        $impuestos = $doc->createElement('cfdi:Impuestos');
        $impuestos->setAttribute('TotalImpuestosTrasladados', number_format($order->tax, 2, '.', ''));

        $traslados = $doc->createElement('cfdi:Traslados');
        $traslado = $doc->createElement('cfdi:Traslado');

        $traslado->setAttribute('Base', number_format($order->subtotal, 2, '.', ''));
        $traslado->setAttribute('Impuesto', '002');
        $traslado->setAttribute('TipoFactor', 'Tasa');
        $traslado->setAttribute('TasaOCuota', '0.160000');
        $traslado->setAttribute('Importe', number_format($order->tax, 2, '.', ''));

        $traslados->appendChild($traslado);
        $impuestos->appendChild($traslados);

        $parent->appendChild($impuestos);
    }
}
