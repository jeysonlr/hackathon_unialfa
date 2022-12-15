<?php

declare(strict_types=1);

namespace Academy\Authentication\Handler;

use Psr\Container\ContainerInterface;
use Academy\Authentication\Service\AuthenticationTokenService;

class AuthenticationTokenHandlerFactory
{
    public function __invoke(ContainerInterface $container): AuthenticationTokenHandler
    {
        $authenticationTokenService = $container->get(AuthenticationTokenService::class);
        return new AuthenticationTokenHandler($authenticationTokenService);
    }
}
