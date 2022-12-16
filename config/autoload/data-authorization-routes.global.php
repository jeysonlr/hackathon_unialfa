<?php

declare(strict_types=1);

return [
    'data-authorization-routes' => [
        'api.ping' => [],
        'authentication.post_login' => [],

        'get.user_byid' => ['admin', 'professional', 'client'],
        'get.users' => ['admin', 'professional', 'client'],
        'post.users' => ['admin'],
    ]
];
