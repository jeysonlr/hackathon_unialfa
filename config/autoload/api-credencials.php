<?php

return [
    'credentials' => [
        'api_server' => [
            'auth' => [
                'api-keys' => [
                    'e0f66c28-f348-4304-9609-3169f0cd07cf' => [ // Clients
                        'allowed-routes' => [
                            'get.user_byid' => ['GET'],
                            'get.users' => ['GET'],
                            'post.users' => ['POST'],
                        ],
                        'rate-limit' => [
                            'max_requests' => 100, // 50 / seconds
                            'reset_time' => 1,
                        ],
                    ],
                ],
            ],
            'open-routes' => [ 'api.ping' ],
        ],
    ],
];
