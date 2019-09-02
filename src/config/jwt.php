<?php
return [
    'routes' => [
        'prefix' => 'api/users/actions',
        'controller' => \Atarek\Jwt\Controllers\AuthController::class,
    ],

    'encode_secret' => false,

    'access' => [
        'expiration_time' => '+1 hour',
        'env_secret' => 'ACCESS_TOKEN_SECRET',

    ],

    'refresh' => [
        'expiration_time' => '+1 day',
        'env_secret' => 'REFRESH_TOKEN_SECRET'
    ]
];
