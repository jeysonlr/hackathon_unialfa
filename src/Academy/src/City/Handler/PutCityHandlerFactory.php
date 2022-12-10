<?php

declare(strict_types=1);

namespace Academy\City\Handler;

use Academy\City\Service\PutCityService;
use Psr\Container\ContainerInterface;

class PutCityHandlerFactory
{
    public function __invoke(ContainerInterface $container): PutCityHandler
    {
        $getCity = $container->get(PutCityService::class);
        return new PutCityHandler(
            $getCity
        );
    }
}
