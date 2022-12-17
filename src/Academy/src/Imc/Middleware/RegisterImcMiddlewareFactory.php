<?php

namespace Academy\Imc\Middleware;

use Academy\Imc\Service\ImcService;
use Academy\User\Service\GetUserService;
use App\Util\Serialize\SerializeUtil;
use App\Util\Validation\ValidationService;
use Psr\Container\ContainerInterface;

final class RegisterImcMiddlewareFactory
{
    public function __invoke(ContainerInterface $container): RegisterImcMiddleware
    {
        $jms = $container->get(SerializeUtil::class);
        $validationService = $container->get(ValidationService::class);
        $getUserService = $container->get(GetUserService::class);

        return new RegisterImcMiddleware($jms, $validationService, $getUserService);
    }
}