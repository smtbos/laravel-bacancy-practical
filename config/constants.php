<?php

return [
    'product' => [
        'notification' => [
            'expiry' => env('PRODUCT_NOTIFICATON_EXPIRY', true),
            'expiry_days' => env('PRODUCT_NOTIFICATON_EXPIRY_DAYS', 10),
            'send_expiry_for_notified_lots' => env('PRODUCT_NOTIFICATON_SEND_EXPIRY_FOR_NOTIFIED_LOTS', true),
            'less_stock' => env('PRODUCT_NOTIFICATON_LESS_STOCK', true),
            'less_stock_quantity' => env('PRODUCT_NOTIFICATON_LESS_STOCK_QUANTITY', 20),
        ]
    ]
];
