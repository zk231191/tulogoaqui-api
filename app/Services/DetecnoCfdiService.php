<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;

class DetecnoCfdiService
{
    protected string $endpoint = 'https://detecno-factura-electronica.com/Emision/cfdiWcfEmisionServicio40_Demo/Detecno.svc';

    public function prueba(string $texto)
    {
        $xml = $this->buildSoapEnvelope(
            'Prueba',
            "
                <tem:Prueba>
                    <tem:valor>{$texto}</tem:valor>
                </tem:Prueba>
            "
        );

        $response = Http::withHeaders([
            'Content-Type' => 'application/soap+xml; charset=utf-8',
        ])->withBody($xml, 'application/soap+xml')
            ->post($this->endpoint);

        return $response->body();
    }

    private function buildSoapEnvelope(string $action, string $bodyContent): string
    {
        return <<<XML
<?xml version="1.0" encoding="utf-8"?>
<s:Envelope xmlns:s="http://www.w3.org/2003/05/soap-envelope"
            xmlns:a="http://www.w3.org/2005/08/addressing"
            xmlns:tem="http://tempuri.org/">
    <s:Header>
        <a:Action s:mustUnderstand="1">
            http://tempuri.org/IDetecno/{$action}
        </a:Action>
        <a:To s:mustUnderstand="1">
            {$this->endpoint}
        </a:To>
    </s:Header>
    <s:Body>
        {$bodyContent}
    </s:Body>
</s:Envelope>
XML;
    }

    public function generar40(string $cfdiXml)
    {
        $xml = $this->buildSoapEnvelope(
            'ComprobanteGenerar40',
            "
        <tem:ComprobanteGenerar40>
            <tem:licencia>{$licencia}</tem:licencia>
            <tem:cerBytes>{$cerBase64}</tem:cerBytes>
            <tem:keyBytes>{$keyBase64}</tem:keyBytes>
            <tem:passBytes>{$password}</tem:passBytes>
            <tem:xml><![CDATA[{$cfdiXml}]]></tem:xml>
        </tem:ComprobanteGenerar40>
        "
        );

        $response = Http::withHeaders([
            'Content-Type' => 'application/soap+xml; charset=utf-8',
        ])->withBody($xml, 'application/soap+xml')
            ->post($this->endpoint);

        return $response->body();
        return $this->parseSoapResponse($response->body());
    }

    private function parseSoapResponse(string $xml)
    {
        $parsed = simplexml_load_string($xml);
        $parsed->registerXPathNamespace('s', 'http://www.w3.org/2003/05/soap-envelope');

        $body = $parsed->xpath('//s:Body')[0];

        return json_decode(json_encode($body), true);
    }
}
