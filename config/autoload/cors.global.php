<?php

use Tuupola\Middleware\CorsMiddleware;
use App\Container\CorsFactory;


return [
    'cors' => [
        "origin" => ["*"],
        "methods" => ["GET", "POST", "PUT", "PATCH", "DELETE", "OPTIONS"],
        "headers.allow" => [
            "Origin",
            "Content-Type",
            "Authorization",
            "Accept",
            "ignoreLoadingBar",
            "X-Requested-With",
            "Access-Control-Allow-Origin",
            "Cache-Control",
            "Pragma",
            "Accept-Encoding",
            "Access-Control-Allow-Headers",
            "Access-Control-Max-Age",
            "Access-Control-Allow-Credentials",
            "Access-Control-Expose-Headers",
            "Content-Security-Policy"
        ],
        "headers.expose" => [],
        "credentials" => false,
        "cache" => 0,
    ],
    'dependencies' => [
        'factories' => [
            CorsMiddleware::class => CorsFactory::class,
        ]
    ],
];