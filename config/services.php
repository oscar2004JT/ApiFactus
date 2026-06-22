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

    'postmark' => [
        'key' => env('POSTMARK_API_KEY'),
    ],

    'resend' => [
        'key' => env('RESEND_API_KEY'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'factus' => [
        'url' => env('FACTUS_URL', 'https://api-sandbox.factus.com.co'),
        'grant_type' => env('FACTUS_GRANT_TYPE', 'password'),
        'client_id' => env('FACTUS_CLIENT_ID', 'a1cb6480-061d-4de6-8198-4bb5a701eb89'),
        'client_secret' => env('FACTUS_CLIENT_SECRET', 'klAYSHfXf7ksTz51z06GXJ6pxKGKp5dAfNAMHlH6'),
        'username' => env('FACTUS_USERNAME', 'sandboxv2@factus.com.co'),
        'password' => env('FACTUS_PASSWORD', 'sandbox2026%'),
    ],

];
