<?php

namespace Academy\Imc\Handler;

use Academy\Imc\Service\ImcService;
use Psr\Container\ContainerInterface;

final class RegisterImcHandlerFactory
{
    public function __invoke(ContainerInterface $container): RegisterImcHandler
    {
        $imcService = $container->get(ImcService::class);

        return new RegisterImcHandler($imcService);
    }
}