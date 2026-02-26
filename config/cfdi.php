<?php

return [
    'mode' => env('CFDI_MODE', 'demo'),

    'demo' => [
        'rfc' => env('CFDI_DEMO_RFC'),
        'name' => env('CFDI_DEMO_NAME'),
        'regimen' => env('CFDI_DEMO_REGIMEN'),
        'zip' => env('CFDI_DEMO_ZIP'),
    ],

    'production' => [
        'rfc' => env('CFDI_RFC'),
        'name' => env('CFDI_NAME'),
        'regimen' => env('CFDI_REGIMEN'),
        'zip' => env('CFDI_ZIP'),
    ],
];
