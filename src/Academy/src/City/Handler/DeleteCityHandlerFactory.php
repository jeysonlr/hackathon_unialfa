<?php

declare(strict_types=1);

namespace Academy\City\Handler;

use Academy\City\Service\DeleteCityService;
use Psr\Container\ContainerInterface;

class DeleteCityHandlerFactory
{
    public function __invoke(ContainerInterface $container): DeleteCityHandler
    {
        $deleteCityService = $container->get(DeleteCityService::class);
        return new DeleteCityHandler(
            $deleteCityService
        );
    }
}
