<?php

return [
    'name' => 'LaravelPWA',
    'manifest' => [
        'name' => env('APP_NAME', 'SIMAA'),
        'short_name' => env('APP_NAME', 'SIMAA'),
        'start_url' => '/',
        'background_color' => '#ffffff',
        'theme_color' => '#343a40',
        'display' => 'standalone',
        'orientation' => 'any',
        'status_bar' => 'black',
        "dir" => "ltr",
        'icons' => [
            '16x16' => [
                'path' => env('APP_URL', 'http://localhost') . '/assets/images/icons/icon-16x16.png',
                'purpose' => 'any'
            ],
            '32x32' => [
                'path' => env('APP_URL', 'http://localhost') . '/assets/images/icons/icon-32x32.png',
                'purpose' => 'any'
            ],
            '57x57' => [
                'path' => env('APP_URL', 'http://localhost') . '/assets/images/icons/icon-57x57.png',
                'purpose' => 'any'
            ],
            '60x60' => [
                'path' => env('APP_URL', 'http://localhost') . '/assets/images/icons/icon-60x60.png',
                'purpose' => 'any'
            ],
            '72x72' => [
                'path' => env('APP_URL', 'http://localhost') . '/assets/images/icons/icon-72x72.png',
                'purpose' => 'any'
            ],
            '76x76' => [
                'path' => env('APP_URL', 'http://localhost') . '/assets/images/icons/icon-76x76.png',
                'purpose' => 'any'
            ],
            '96x96' => [
                'path' => env('APP_URL', 'http://localhost') . '/assets/images/icons/icon-96x96.png',
                'purpose' => 'any'
            ],
            '114x114' => [
                'path' => env('APP_URL', 'http://localhost') . '/assets/images/icons/icon-114x114.png',
                'purpose' => 'any'
            ],
            '120x120' => [
                'path' => env('APP_URL', 'http://localhost') . '/assets/images/icons/icon-120x120.png',
                'purpose' => 'any'
            ],
            '128x128' => [
                'path' => env('APP_URL', 'http://localhost') . '/assets/images/icons/icon-128x128.png',
                'purpose' => 'any'
            ],
            '144x144' => [
                'path' => env('APP_URL', 'http://localhost') . '/assets/images/icons/icon-144x144.png',
                'purpose' => 'any'
            ],
            '152x152' => [
                'path' => env('APP_URL', 'http://localhost') . '/assets/images/icons/icon-152x152.png',
                'purpose' => 'any'
            ],
            '180x180' => [
                'path' => env('APP_URL', 'http://localhost') . '/assets/images/icons/icon-180x180.png',
                'purpose' => 'any'
            ],
            '192x192' => [
                'path' => env('APP_URL', 'http://localhost') . '/assets/images/icons/icon-192x192.png',
                'purpose' => 'any'
            ],
            '384x384' => [
                'path' => env('APP_URL', 'http://localhost') . '/assets/images/icons/icon-384x384.png',
                'purpose' => 'any'
            ],
            '512x512' => [
                'path' => env('APP_URL', 'http://localhost') . '/assets/images/icons/icon-512x512.png',
                'purpose' => 'any'
            ],
        ],
        'splash' => [
            '640x1136' => env('APP_URL', 'http://localhost') . '/assets/images/icons/splash-640x1136.png',
            '750x1334' => env('APP_URL', 'http://localhost') . '/assets/images/icons/splash-750x1334.png',
            '828x1792' => env('APP_URL', 'http://localhost') . '/assets/images/icons/splash-828x1792.png',
            '1125x2436' => env('APP_URL', 'http://localhost') . '/assets/images/icons/splash-1125x2436.png',
            '1242x2208' => env('APP_URL', 'http://localhost') . '/assets/images/icons/splash-1242x2208.png',
            '1242x2688' => env('APP_URL', 'http://localhost') . '/assets/images/icons/splash-1242x2688.png',
            '1536x2048' => env('APP_URL', 'http://localhost') . '/assets/images/icons/splash-1536x2048.png',
            '1668x2224' => env('APP_URL', 'http://localhost') . '/assets/images/icons/splash-1668x2224.png',
            '1668x2388' => env('APP_URL', 'http://localhost') . '/assets/images/icons/splash-1668x2388.png',
            '2048x2732' => env('APP_URL', 'http://localhost') . '/assets/images/icons/splash-2048x2732.png',
        ],
        'shortcuts' => [
            [
                'name' => 'Login',
                'description' => 'Login akun',
                'url' => '/login',
                'icons' => [
                    "src" => env('APP_URL', 'http://localhost') . "/assets/images/icons/icon-72x72.png",
                    "purpose" => "any"
                ]
            ],
            [
                'name' => 'Dashboard',
                'description' => 'Halaman utama',
                'url' => '/dashboard',
                'icons' => [
                    "src" => env('APP_URL', 'http://localhost') . "/assets/images/icons/icon-72x72.png",
                    "purpose" => "any"
                ]
            ]
        ],
        'custom' => [
            'lang' => 'id,in',
            'description' => env('APP_DESCRIPTION', 'Sistem informasi manajemen anggaran & arsip'),
        ]
    ]
];
