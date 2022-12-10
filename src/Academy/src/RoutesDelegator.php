<?php

declare(strict_types=1);

namespace Academy;

use Mezzio\Application;
use Psr\Container\ContainerInterface;
use Academy\User\Handler\GetUserByIdHandler;
use Academy\User\Handler\GetAllUsersHandler;

class RoutesDelegator
{
    /**
     * @param ContainerInterface $container
     * @param string $serviceName
     * @param callable $callback
     * @return Application
     */
    public function __invoke(ContainerInterface $container, string $serviceName, callable $callback): Application
    {
        /**
         * @var Application $app
         */
        $app = $callback();

        $app->get("/v1/user/{id:\d+}", [
           GetUserByIdHandler::class,
        ], "get.user_byid");
        
        $app->get("/v1/users", [
           GetAllUsersHandler::class,
        ], "get.users");

        return $app;
    }
}
