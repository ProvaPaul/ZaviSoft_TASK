<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Mailgun, Postmark, AWS and more. This file provides the de facto
    | location for this type of information, allowing packages to have
    | a conventional file to locate the various service credentials.
    |
    */

    'mailgun' => [
        'domain' => env('MAILGUN_DOMAIN'),
        'secret' => env('MAILGUN_SECRET'),
        'endpoint' => env('MAILGUN_ENDPOINT', 'api.mailgun.net'),
        'scheme' => 'https',
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'foodpanda' => [
        'client_id' => env('FOODPANDA_CLIENT_ID'),
        'redirect_uri' => env('FOODPANDA_REDIRECT_URI'),
    ],

    // Ecommerce OAuth2 server credentials (foodpanda is the client)
    'ecommerce' => [
        'url'           => env('ECOMMERCE_URL', 'http://127.0.0.1:8000'),
        'client_id'     => env('ECOMMERCE_CLIENT_ID', '3'),
        'client_secret' => env('ECOMMERCE_CLIENT_SECRET'),
        'redirect_uri'  => env('ECOMMERCE_REDIRECT_URI', 'http://127.0.0.1:8001/callback'),
    ],

];
