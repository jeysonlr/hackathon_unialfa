<?php

declare(strict_types=1);

namespace Academy\City\Handler;

use Psr\Container\ContainerInterface;
use Academy\City\Service\GetCityService;

class GetCityByIdHandlerFactory
{
    public function __invoke(ContainerInterface $container): GetCityByIdHandler
    {
        $getCity = $container->get(GetCityService::class);
        return new GetCityByIdHandler(
            $getCity
        );
    }
}
