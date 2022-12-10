<?php

declare(strict_types=1);

namespace Academy\State\Handler;

use Academy\State\Service\PutStateService;
use Psr\Container\ContainerInterface;

class PutStateHandlerFactory
{
    public function __invoke(ContainerInterface $container): PutStateHandler
    {
        $putCity = $container->get(PutStateService::class);
        return new PutStateHandler(
            $putCity
        );
    }
}
