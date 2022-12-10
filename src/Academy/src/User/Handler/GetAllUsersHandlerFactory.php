<?php

declare(strict_types=1);

namespace Academy\User\Handler;

use Academy\User\Service\GetUserService;
use Psr\Container\ContainerInterface;

class GetAllUsersHandlerFactory
{
    public function __invoke(ContainerInterface $container): GetAllUsersHandler
    {
        $getUserService = $container->get(GetUserService::class);
        return new GetAllUsersHandler($getUserService);
    }
}
