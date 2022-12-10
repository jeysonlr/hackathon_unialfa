<?php

declare(strict_types=1);

namespace Academy\City\Middleware;

use App\Util\Serialize\SerializeUtil;
use Psr\Container\ContainerInterface;
use App\Util\Validation\ValidationService;
use Academy\City\Service\GetCityService;

class PutCityMiddlewareFactory
{
    public function __invoke(ContainerInterface $container): PutCityMiddleware
    {
        $serialize = $container->get(SerializeUtil::class);
        $validationService = $container->get(ValidationService::class);
        $getCityService = $container->get(GetCityService::class);
        return new PutCityMiddleware(
            $serialize,
            $validationService,
            $getCityService
        );
    }
}
