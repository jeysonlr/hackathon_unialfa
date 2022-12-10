<?php

declare(strict_types=1);

namespace Academy\State\Handler;

use Psr\Container\ContainerInterface;
use Academy\State\Service\GetStateService;

class GetAllStateHandlerFactory
{
    public function __invoke(ContainerInterface $container): GetAllStateHandler
    {
        $getState = $container->get(GetStateService::class);
        return new GetAllStateHandler(
            $getState
        );
    }
}
