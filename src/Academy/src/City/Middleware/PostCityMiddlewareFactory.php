<?php

declare(strict_types=1);

namespace Academy\City\Middleware;

use App\Util\Serialize\SerializeUtil;
use Psr\Container\ContainerInterface;
use App\Util\Validation\ValidationService;
use Academy\City\Service\GetCityService;
use Academy\State\Service\GetStateService;

class PostCityMiddlewareFactory
{
    public function __invoke(ContainerInterface $container): PostCityMiddleware
    {
        $serialize = $container->get(SerializeUtil::class);
        $validationService = $container->get(ValidationService::class);
        $getCityService = $container->get(GetCityService::class);
        $getStateService = $container->get(GetStateService::class);
        return new PostCityMiddleware(
            $serialize,
            $validationService,
            $getCityService,
            $getStateService
        );
    }
}
