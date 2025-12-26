<?php

return [
    'paths' => ['api/*', 'sanctum/csrf-cookie', 'stream*'], // Agregar stream*

    'allowed_methods' => ['*'],

    'allowed_origins' => ['http://localhost:5173'], // Tu URL de Vite/Vue

    'allowed_origins_patterns' => [],

    'allowed_headers' => ['*'],

    'exposed_headers' => [],

    'max_age' => 0,

    'supports_credentials' => true, // Importante para tokens
];
