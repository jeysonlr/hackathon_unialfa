<?php

declare(strict_types=1);

namespace Academy\Authentication\Container;

use Firebase\JWT\JWT;
use Psr\Container\ContainerInterface;

class JWTFactory
{
    public function __invoke(ContainerInterface $container): JWT
    {
        return new JWT();
    }
}
