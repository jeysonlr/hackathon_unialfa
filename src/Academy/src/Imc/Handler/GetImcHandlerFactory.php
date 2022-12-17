<?php

namespace Academy\Imc\Handler;

use Academy\Imc\Service\ImcService;
use Academy\User\Service\GetUserService;
use Psr\Container\ContainerInterface;

final class GetImcHandlerFactory
{
    public function __invoke(ContainerInterface $container): GetImcHandler
    {
        $imcService = $container->get(ImcService::class);
        $getUserService = $container->get(GetUserService::class);
        
        return new GetImcHandler($imcService, $getUserService);
    }
}