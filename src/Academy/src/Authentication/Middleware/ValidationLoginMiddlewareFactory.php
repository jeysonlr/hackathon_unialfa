<?php

declare(strict_types=1);

namespace Academy\Authentication\Middleware;

use Academy\User\Service\GetUserService;
use App\Util\Serialize\SerializeUtil;
use App\Util\Validation\ValidationService;
use Psr\Container\ContainerInterface;

class ValidationLoginMiddlewareFactory
{
    public function __invoke(ContainerInterface $container): ValidationLoginMiddleware
    {
        $jms = $container->get(SerializeUtil::class);
        $validationService = $container->get(ValidationService::class);
        $getUserService = $container->get(GetUserService::class);
        return new ValidationLoginMiddleware(
            $jms,
            $validationService,
            $getUserService,
        );
    }
}
