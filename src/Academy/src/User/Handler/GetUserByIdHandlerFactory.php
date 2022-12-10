<?php

declare(strict_types=1);

namespace Academy\User\Handler;

use Academy\User\Service\GetUserService;
use Psr\Container\ContainerInterface;

class GetUserByIdHandlerFactory
{
    public function __invoke(ContainerInterface $container): GetUserByIdHandler
    {
        $getUserService = $container->get(GetUserService::class);
        return new GetUserByIdHandler(
            $getUserService
        );
    }
}
