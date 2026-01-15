<?php

return [
    'paths' => ['api/*', 'sanctum/csrf-cookie'], // Agregar stream*

    'allowed_methods' => ['*'],

    'allowed_origins' => ['https://tulogoaqui.com.mx'], // Tu URL de Vite/Vue

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true, // Importante para tokens
];
