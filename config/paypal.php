<?php

return [
	// Can only be 'sandbox' or 'live'
	'mode' => env('PAYPAL_MODE', 'sandbox'),

	'sandbox' => [
		'username' 		=> env('PAYPAL_SANDBOX_API_USERNAME', ''),
		'password' 		=> env('PAYPAL_SANDBOX_API_PASSWORD', ''),
		'secret' 		=> env('PAYPAL_SANDBOX_API_SECRET', ''),
		'certificate' 	=> env('PAYPAL_SANDBOX_API_CERTIFICATE', ''),
		'app_id' 		=> 'APP-80W284485P519543T',
	],

	'live' => [
		'username' 		=> env('PAYPAL_LIVE_API_USERNAME', ''),
		'password' 		=> env('PAYPAL_LIVE_API_PASSWORD', ''),
		'secret' 		=> env('PAYPAL_LIVE_API_SECRET', ''),
		'certificate' 	=> env('PAYPAL_LIVE_API_CERTIFICATE', ''),
		'app_id' 		=> '',
	],

	// Can only be 'Sale', 'Authorization' or 'Order'
	'payment_action' 	=> 'Sale',

	'currency' 			=> env('PAYPAL_CURRENCY', 'USD'),
	
	'billing_type' 		=> 'MerchantInitiateBilling',
	
	'notify_url' 		=> '',
	
	// Force gateway language
	'locale' 			=> 'es_ES',
	
	// Validate SSL when creating api client
	'validate_ssl' 		=> true,
];