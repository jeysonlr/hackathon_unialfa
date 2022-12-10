<?php

declare(strict_types=1);

namespace Academy\State\Handler;

use Psr\Container\ContainerInterface;
use Academy\State\Service\DeleteStateService;

class DeleteStateHandlerFactory
{
    public function __invoke(ContainerInterface $container): DeleteStateHandler
    {
        $deleteStateService = $container->get(DeleteStateService::class);
        return new DeleteStateHandler(
            $deleteStateService
        );
    }
}
