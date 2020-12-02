<?php

return [
	// Can only be 'sandbox' Or 'live'. If empty or invalid, 'live' will be used.
    'mode'    => env('PAYPAL_MODE', 'sandbox'),

    'sandbox' => [
        'client_id'         => env('PAYPAL_SANDBOX_CLIENT_ID', ''),
        'client_secret'     => env('PAYPAL_SANDBOX_CLIENT_SECRET', ''),
        'app_id'            => 'APP-80W284485P519543T',
    ],

    'live' => [
        'client_id'         => env('PAYPAL_LIVE_CLIENT_ID', ''),
        'client_secret'     => env('PAYPAL_LIVE_CLIENT_SECRET', ''),
        'app_id'            => '',
    ],

    // Can only be 'Sale', 'Authorization' or 'Order'
    'payment_action' => env('PAYPAL_PAYMENT_ACTION', 'Sale'),

    'currency'       => env('PAYPAL_CURRENCY', 'USD'),

    // Change this accordingly for your application.
    'notify_url'     => env('PAYPAL_NOTIFY_URL', ''),

    // force gateway language  i.e. it_IT, es_ES, en_US ... (for express checkout only)
    'locale'         => env('PAYPAL_LOCALE', 'en_US'),

    // Validate SSL when creating api client.
    'validate_ssl'   => env('PAYPAL_VALIDATE_SSL', true),
];