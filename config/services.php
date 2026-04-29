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
    ],

    'postmark' => [
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'google' => [
        'maps_api_key' => env('GOOGLE_MAPS_API_KEY'),
    ],

    'bkash' => [
        'app_key' => env('BKASH_APP_KEY'),
        'app_secret' => env('BKASH_APP_SECRET'),
        'username' => env('BKASH_USERNAME'),
        'password' => env('BKASH_PASSWORD'),
        'base_url' => env('BKASH_BASE_URL', 'https://checkout.sandbox.bka.sh/v1.2.0-beta'),
    ],

    'sslcommerz' => [
        'store_id' => env('STORE_ID'),
        'store_password' => env('STORE_PASSWORD'),
        'api_domain_url' => env('API_DOMAIN_URL', 'https://sandbox.sslcommerz.com'),
    ],

];
