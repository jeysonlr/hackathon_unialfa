<?php

declare(strict_types=1);

namespace Academy;

use Academy\City\Handler\DeleteCityHandler;
use Academy\City\Handler\DeleteCityHandlerFactory;
use Academy\State\Handler\DeleteStateHandler;
use Academy\State\Handler\DeleteStateHandlerFactory;
use Academy\User\Handler\GetUserByIdHandler;
use Mezzio\Application;
use Academy\State\Handler\GetAllStateHandler;
use Academy\State\Handler\GetStateByIdHandler;
use Academy\State\Handler\PostStateHandler;
use Academy\State\Handler\PutStateHandler;
use Academy\State\Middleware\PostStateMiddleware;
use Academy\State\Middleware\PutStateMiddleware;
use Psr\Container\ContainerInterface;
use Academy\City\Handler\PutCityHandler;
use Academy\City\Handler\PostCityHandler;
use Academy\City\Handler\GetAllCityHandler;
use Academy\City\Handler\GetCityByIdHandler;
use Academy\City\Middleware\PutCityMiddleware;
use Academy\City\Middleware\PostCityMiddleware;

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

        $app->post("/v1/cidades", [
            PostCityMiddleware::class,
            PostCityHandler::class,
        ], "post.city");

        $app->put("/v1/cidade/{cidadeId:\d+}", [
            PutCityMiddleware::class,
            PutCityHandler::class,
        ], "put.city");

        $app->delete("/v1/cidade/{cidadeId:\d+}", [
            DeleteCityHandler::class,
        ], "delete.city");

        $app->get("/v1/cidades", [
            GetAllCityHandler::class,
        ], "get.all_city");

        $app->get("/v1/cidade/{cidadeId:\d+}", [
            GetCityByIdHandler::class,
        ], "get.city_byid");

        $app->post("/v1/estados", [
            PostStateMiddleware::class,
            PostStateHandler::class,
        ], "post.state");

        $app->put("/v1/estado/{estadoId:\d+}", [
            PutStateMiddleware::class,
            PutStateHandler::class,
        ], "put.state");

        $app->delete("/v1/estado/{estadoId:\d+}", [
            DeleteStateHandler::class,
        ], "delete.state");

        $app->get("/v1/estados", [
            GetAllStateHandler::class,
        ], "get.all_state");

        $app->get("/v1/estado/{estadoId:\d+}", [
            GetStateByIdHandler::class,
        ], "get.state_byid");

        $app->get('teste', [
           GetUserByIdHandler::class,
        ], 'get.user_byid');
        return $app;
    }
}
