<?php

declare(strict_types=1);

namespace Academy\Authentication\Middleware;

use Psr\Container\ContainerInterface;
use Academy\Authentication\Service\AuthenticationTokenService;

class AuthenticationTokenMiddlewareFactory
{
    public function __invoke(ContainerInterface $container): AuthenticationTokenMiddleware
    {
        $routes = $container->get('config')['data-authorization-routes'];
        $authenticationTokenService = $container->get(AuthenticationTokenService::class);
        $dataUser = $container->get('config')['data-user'];
        return new AuthenticationTokenMiddleware(
            $routes,
            $authenticationTokenService,
            $dataUser
        );
    }
}
