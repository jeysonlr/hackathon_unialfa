<?php

declare(strict_types=1);

namespace Academy;

use Academy\Authentication\Handler\AuthenticationTokenHandler;
use Mezzio\Application;
use Psr\Container\ContainerInterface;
use Academy\User\Handler\PostUsersHandler;
use Academy\User\Handler\GetUserByIdHandler;
use Academy\User\Handler\GetAllUsersHandler;
use Academy\User\Middleware\PostUserMiddleware;
use Academy\Authentication\Middleware\ValidationLoginMiddleware;

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

        $app->post("/v1/login", [
            ValidationLoginMiddleware::class,
            AuthenticationTokenHandler::class,
        ], "authentication.post_login");

        $app->get("/v1/user/{id:\d+}", [
           GetUserByIdHandler::class,
        ], "get.user_byid");
        
        $app->get("/v1/users", [
           GetAllUsersHandler::class,
        ], "get.users");

        $app->post("/v1/users", [
            PostUserMiddleware::class,
            PostUsersHandler::class,
            ], "post.users");

        return $app;
    }
}
