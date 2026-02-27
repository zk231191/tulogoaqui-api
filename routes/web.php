<?php

use App\Http\Controllers\API\OrdersController;
use Illuminate\Support\Facades\Route;
use App\Services\Billing\BillingManager;


Route::get('/orders/{order}/invoice', [OrdersController::class, 'invoice']);

Route::get('/test-detecno', function (\App\Services\DetecnoCfdiService $service) {
    return response()->make(
        $service->prueba('Angel'),
        200,
        ['Content-Type' => 'text/xml']
    );
});

Route::get('/test-facturama', function (BillingManager $billing) {

    $payload = [
        "CfdiType" => "I",
        "ExpeditionPlace" => config('company.zip_code'),

        "PaymentForm" => "01",
        "PaymentMethod" => "PUE",
        "PaymentConditions" => "Contado",

        "Receiver" => [
            "Rfc" => "HEFA911123828",
            "Name" => "ANGEL DANIEL HERNANDEZ FERNANDEZ",
            "CfdiUse" => "G03",
            "FiscalRegime" => "625",
            "TaxZipCode" => 66643,
        ],

        "Items" => [
            [
                "ProductCode" => "01010101",
                "Description" => "Servicio de prueba",
                "Unit" => "E48",
                "UnitCode" => "E48",
                "UnitPrice" => 100.00,
                "Quantity" => 1,
                "Subtotal" => 100.00,
                "TaxObject" => "02",
                "Total" => 116.00, // 👈 IMPORTANTE

                "Taxes" => [
                    [
                        "Name" => "IVA",
                        "Rate" => 0.16,
                        "Base" => 100.00,
                        "Total" => 16.00,
                        "IsRetention" => false
                    ]
                ]
            ]
        ]
    ];

    //dd($payload);

    try {
        $response = $billing->create($payload);
        return response()->json($response);
    } catch (\Throwable $e) {
        return response()->json([
            'error' => $e->getMessage()
        ], 500);
    }

});
