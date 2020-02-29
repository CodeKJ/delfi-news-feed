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

    /*
     * Delfi.lv RSS feed data
     */
    'delfi' => [
        'rss' => 'https://www.delfi.lv/rss/?channel=',
        'default_channel' => 'delfi',
        'default_paginate' => 10,
        'channels' => [
            'delfi'         => 'Visas DELFI jaunākās ziņas',
            'aculiecinieks' => 'Aculiecinieka ziņas',
            'auto'          => 'Auto ziņas',
            'bizness'       => 'Biznesa ziņas',
            'calis'         => 'CĀLIS.LV ziņas',
            'izklaide'      => 'Izklaide ziņas',
            'kultura'       => 'Kultūras ziņas',
            'laikazinas'    => 'Laika ziņas',
            'majadarzs'     => 'Dārzs ziņas',
            'mansdraugs'    => 'Mans draugs ziņas',
            'orakuls'       => 'Orakuls ziņas',
            'receptes'      => 'Recepšu ziņas',
            'skats'         => 'Skats.lv ziņas',
            'sports'        => 'Sporta ziņas',
            'tasty'         => 'Tasty ziņas',
            'tavamaja'      => 'Tava māja ziņas',
            'turismagids'   => 'Tūrismagids.lv ziņas',
            'tv'            => 'DELFI TV ziņas',
            'vina'          => 'Viņa.lv ziņas',
        ],
    ],

    /*
     * Facebook app credentials
     * https://developers.facebook.com/apps
     */
    'facebook' => [
        'client_id' => env('FACEBOOK_CLIENT_ID'),
        'client_secret' => env('FACEBOOK_CLIENT_SECRET'),
        'redirect' => env('FACEBOOK_REDIRECT'),
    ],

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

];
