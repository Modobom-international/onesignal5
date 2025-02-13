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
        'token' => env('POSTMARK_TOKEN'),
    ],

    'ses' => [
        'key' => env('AWS_ACCESS_KEY_ID'),
        'secret' => env('AWS_SECRET_ACCESS_KEY'),
        'region' => env('AWS_DEFAULT_REGION', 'us-east-1'),
    ],

    'resend' => [
        'key' => env('RESEND_KEY'),
    ],

    'slack' => [
        'notifications' => [
            'bot_user_oauth_token' => env('SLACK_BOT_USER_OAUTH_TOKEN'),
            'channel' => env('SLACK_BOT_USER_DEFAULT_CHANNEL'),
        ],
    ],

    'telegram-bot-api' => [
        'token' => env('TELEGRAM_MEDIAFIRE_BOT_TOKEN', 'YOUR BOT TOKEN HERE')
    ],

    'godaddy' => [
        'api_key'    => env('GODADDY_API_KEY'),
        'api_secret' => env('GODADDY_API_SECRET'),
        'api_url'    => env('GODADDY_API_URL'),
        'shopper_id'    => env('GODADDY_SHOPPER_ID'),
    ],

    'godaddy_tuan' => [
        'api_key'    => env('GODADDY_TUAN_API_KEY'),
        'api_secret' => env('GODADDY_TUAN_API_SECRET'),
        'api_url'    => env('GODADDY_TUAN_API_URL'),
        'shopper_id'    => env('GODADDY_TUAN_SHOPPER_ID'),
    ],

    'godaddy_linh' => [
        'api_key'    => env('GODADDY_LINH_API_KEY'),
        'api_secret' => env('GODADDY_LINH_API_SECRET'),
        'api_url'    => env('GODADDY_LINH_API_URL'),
        'shopper_id'    => env('GODADDY_LINH_SHOPPER_ID'),
    ],

    'cloudflare' => [
        'api_token_edit_zone_dns'    => env('CLOUDFLARE_API_TOKEN_EDIT_ZONE_DNS'),
        'api_token_edit_zone'    => env('CLOUDFLARE_API_TOKEN_EDIT_ZONE'),
        'account_id' => env('CLOUDFLARE_ACCOUNT_ID'),
        'api_url'    => env('CLOUDFLARE_API_URL'),
    ],

    'ssh' => [
        'ssh_user' => env('SSH_USER'),
        'ssh_private_key'    => env('SSH_PRIVATE_KEY'),
    ],

    'ip_server' => [
        'wp1'    => env('IP_WP1'),
        'wp2'    => env('IP_WP2'),
        'wp3'    => env('IP_WP3'),
    ],

];
