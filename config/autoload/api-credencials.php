<?php

return [
    'credentials' => [
        'api_server' => [
            'auth' => [
                'api-keys' => [
                    'e0f66c28-f348-4304-9609-3169f0cd07cf' => [ // Clients
                        'allowed-routes' => [
                            'post.city' => ['POST'],
                            'put.city' => ['PUT'],
                            'delete.city' => ['DELETE'],
                            'get.city_byid' => ['GET'],
                            'get.all_city' => ['GET'],
                            'post.state' => ['POST'],
                            'put.state' => ['PUT'],
                            'delete.state' => ['DELETE'],
                            'get.state_byid' => ['GET'],
                            'get.all_state' => ['GET'],
                        ],
                        'rate-limit' => [
                            'max_requests' => 100, // 50 / seconds
                            'reset_time' => 1,
                        ],
                    ],
                ],
            ],
            'open-routes' => [ 'home', 'api.ping' ],
        ],
    ],
];
