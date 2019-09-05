<?php
return [
    'routes' => [
        'prefix' => [
            // 'users' => 'api/users/actions',
        ],
        'controller' => [
            // 'users' => \Atarek\Jwt\Controllers\AuthController::class,
        ],
    ],

    'encode_secret' => false,

    'access' => [
        'expiration_time' => '+1 hour',
        'env_secret' => env('ACCESS_TOKEN_SECRET'),

    ],

    'refresh' => [
        'expiration_time' => '+1 day',
        'env_secret' => env('REFRESH_TOKEN_SECRET')
    ]
];