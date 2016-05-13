<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Third Party Services
    |--------------------------------------------------------------------------
    |
    | This file is for storing the credentials for third party services such
    | as Stripe, Mailgun, Mandrill, and others. This file provides a sane
    | default location for this type of information, allowing packages
    | to have a conventional place to find your various credentials.
    |
    */

    'mailgun' => [
        'domain' => env('bond9555@gmail.com'),
        'secret' => env('MAILGUN_SECRET'),
    ],

    'ses' => [
        'key' => env('SES_KEY'),
        'secret' => env('SES_SECRET'),
        'region' => 'us-east-1',
    ],

    'sparkpost' => [
        'secret' => env('SPARKPOST_SECRET'),
    ],

    'stripe' => [
        'model' => App\User::class,
        'key' => env('STRIPE_KEY'),
        'secret' => env('STRIPE_SECRET'),
    ],

    'facebook' =>[
        'client_id' =>  '277447625924303',
        'client_secret' => 'e36703da12effb0f1858aa3e69399f88',
        'redirect' => 'http://laravel.learn.com/facebookCallback'
    ],
    
    'google' =>[
    'client_id' =>'101237898369-rv295e74bgvop00k43v3vpqbdaur8hrd.apps.googleusercontent.com',
    'client_secret' => 'TW2XrFB45KsH8cQnPAFJDxB_',
    'redirect' => 'http://laravel.learn.com/googleCallback'
    ],

    'yandex' =>[
        'client_id' =>'9c0dd082d12647cdba5c7ea82f472252',
        'client_secret' => 'fbde8a1830da49238fcb041982ee6185',
        'redirect' => 'http://laravel.learn.com/yandexCallback'
    ],

    'mail' =>[
        'client_id' =>'743829',
        'client_secret' => 'c022437d31ffed2594252ba3ebfd84c3',
        'redirect' => 'http://laravel.learn.com/mailruCallback'
    ],

    'odnoklasniki' =>[
        'client_id' =>'1246864896',
        'client_secret' => 'CA475322F6998C12BAA132F0',
        'redirect' => 'http://laravel.learn.com/odnoCallback'
    ],
];
