<?php

declare(strict_types=1);

return [
    'data-authorization-routes' => [
        'api.ping' => [],
        'authentication.post_login' => [],

        'get.user_byid' => ['admin', 'professional', 'client'],
        'get.users' => ['admin', 'professional', 'client'],
        'post.users' => ['admin'],

        'register.imc' => ['admin', 'professional'],
        'get.imc' => ['admin', 'professional', 'client'],
        'get.imc_by_profissional' => ['admin', 'professional']
    ]
];
