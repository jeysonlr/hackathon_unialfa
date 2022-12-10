<?php

declare(strict_types=1);

namespace App\Container;

use Psr\Container\ContainerInterface;
use Tuupola\Middleware\CorsMiddleware;

class CorsFactory
{
    public function __invoke(ContainerInterface $container)
    {
        $cors = $container->get('config')['cors'];
        return new CorsMiddleware($cors);
    }
}
