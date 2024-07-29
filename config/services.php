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

    'angel_broking' => [
        'api_key' => env('ANGEL_BROKING_API_KEY'),
        'client_code' => env('ANGEL_BROKING_CLIENT_CODE'),
        'password' => env('ANGEL_BROKING_PASSWORD'),
        'totp' => env('ANGEL_BROKING_TOTP'), // Optional, if 2FA is enabled
        'access_token' => env('ANGEL_BROKING_ACCESS_TOKEN'),
        'api_endpoint' => env('ANGEL_BROKING_API_ENDPOINT'),
    ],



];
