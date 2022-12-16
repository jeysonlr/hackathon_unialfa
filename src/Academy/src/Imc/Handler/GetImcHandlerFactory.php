<?php

namespace Academy\Imc\Handler;

use Academy\Imc\Service\ImcService;
use Psr\Container\ContainerInterface;

final class GetImcHandlerFactory
{
    public function __invoke(ContainerInterface $container): GetImcHandler
    {
        $imcService = $container->get(ImcService::class);
        
        return new GetImcHandler($imcService);
    }
}