<?php

declare(strict_types=1);

namespace Academy\State\Middleware;

use App\Util\Serialize\SerializeUtil;
use Psr\Container\ContainerInterface;
use App\Util\Validation\ValidationService;
use Academy\State\Service\GetStateService;

class PostStateMiddlewareFactory
{
    public function __invoke(ContainerInterface $container): PostStateMiddleware
    {
        $serialize = $container->get(SerializeUtil::class);
        $validationService = $container->get(ValidationService::class);
        $getStateService = $container->get(GetStateService::class);
        return new PostStateMiddleware(
            $serialize,
            $validationService,
            $getStateService
        );
    }
}
