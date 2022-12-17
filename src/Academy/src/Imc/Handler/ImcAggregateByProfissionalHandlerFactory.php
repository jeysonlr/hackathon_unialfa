<?php

namespace Academy\Imc\Handler;

use Academy\Imc\Service\ImcService;
use Psr\Container\ContainerInterface;

final class ImcAggregateByProfissionalHandlerFactory
{
    public function __invoke(ContainerInterface $container): ImcAggregateByProfissionalHandler
    {
        $imcService = $container->get(ImcService::class);
        
        return new ImcAggregateByProfissionalHandler($imcService);
    }
}