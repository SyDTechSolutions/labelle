<?php

return [
    'environment' => env('API_ENV', 'sandbox'),
    
    'factura' => [
        'sandbox' => [
            'url' => env('API_FACTURA_URL_SANDBOX'),
        ],
        'production' => [
            'url' => env('API_FACTURA_URL_PRODUCTION'),
        ],
    ],
];
