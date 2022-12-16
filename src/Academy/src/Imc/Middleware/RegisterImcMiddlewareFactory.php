<?php

namespace Academy\Imc\Middleware;

use Academy\Imc\Service\ImcService;
use App\Util\Serialize\SerializeUtil;
use App\Util\Validation\ValidationService;
use Psr\Container\ContainerInterface;

final class RegisterImcMiddlewareFactory
{
    public function __invoke(ContainerInterface $container): RegisterImcMiddleware
    {
        $jms = $container->get(SerializeUtil::class);
        $validationService = $container->get(ValidationService::class);

        return new RegisterImcMiddleware($jms, $validationService);
    }
}