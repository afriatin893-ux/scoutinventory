<?php

return [

    'defaults' => [
        'guard' => 'admin',
        'passwords' => 'peminjams',
    ],

    'guards' => [
        'admin' => [
            'driver' => 'session',
            'provider' => 'admins',
        ],
        'peminjam' => [
            'driver' => 'session',
            'provider' => 'peminjams',
        ],
    ],

    'providers' => [
        'admins' => [
            'driver' => 'eloquent',
            'model' => App\Models\Admin::class,
        ],
        'peminjams' => [
            'driver' => 'eloquent',
            'model' => App\Models\Peminjam::class,
        ],
    ],

    'passwords' => [
        'peminjams' => [
            'provider' => 'peminjams',
            'table' => env('AUTH_PASSWORD_RESET_TOKEN_TABLE', 'password_reset_tokens'),
            'expire' => 60,
            'throttle' => 60,
        ],
    ],

    'password_timeout' => env('AUTH_PASSWORD_TIMEOUT', 10800),

];
