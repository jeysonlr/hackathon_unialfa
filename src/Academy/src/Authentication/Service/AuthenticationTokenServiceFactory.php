<?php

declare(strict_types=1);

namespace Academy\Authentication\Service;

use Psr\Container\ContainerInterface;
use Academy\Authentication\Container\JWTFactory;

class AuthenticationTokenServiceFactory
{
    public function __invoke(ContainerInterface $container): AuthenticationTokenService
    {
        $jwt = $container->get(JWTFactory::class);
        $tokenData = $container->get('config')['data-jwt'];
        return new AuthenticationTokenService(
            $jwt,
            $tokenData,
        );
    }
}
