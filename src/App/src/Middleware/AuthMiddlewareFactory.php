<?php

declare(strict_types=1);

namespace App\Middleware;

use Psr\Container\ContainerInterface;

class AuthMiddlewareFactory
{
    public function __invoke(ContainerInterface $container): AuthMiddleware
    {
        $apiKeys    = $container->get('config')['credentials']['api_server']['auth']['api-keys'] ?? [];
        $openRoutes = $container->get('config')['credentials']['api_server']['open-routes'] ?? [];

        return new AuthMiddleware(
            $apiKeys,
            $openRoutes
        );
    }
}
