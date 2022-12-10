<?php

declare(strict_types=1);

namespace Academy;

use Academy\City\Handler\DeleteCityHandler;
use Academy\City\Handler\DeleteCityHandlerFactory;
use Academy\City\Handler\GetAllCityHandler;
use Academy\City\Handler\GetAllCityHandlerFactory;
use Academy\City\Handler\PostCityHandler;
use Academy\City\Handler\PostCityHandlerFactory;
use Academy\City\Handler\PutCityHandler;
use Academy\City\Handler\PutCityHandlerFactory;
use Academy\City\Middleware\PostCityMiddleware;
use Academy\City\Middleware\PostCityMiddlewareFactory;
use Academy\City\Middleware\PutCityMiddleware;
use Academy\City\Middleware\PutCityMiddlewareFactory;
use Academy\City\Service\DeleteCityService;
use Academy\City\Service\DeleteCityServiceFactory;
use Academy\City\Service\GetCityService;
use Academy\City\Service\GetCityServiceFactory;
use Academy\City\Service\PostCityService;
use Academy\City\Service\PostCityServiceFactory;
use Academy\City\Service\PutCityService;
use Academy\City\Service\PutCityServiceFactory;
use Academy\City\Handler\GetCityByIdHandler;
use Academy\City\Handler\GetCityByIdHandlerFactory;
use Academy\State\Handler\DeleteStateHandler;
use Academy\State\Handler\DeleteStateHandlerFactory;
use Academy\State\Handler\GetAllStateHandler;
use Academy\State\Handler\GetAllStateHandlerFactory;
use Academy\State\Handler\GetStateByIdHandler;
use Academy\State\Handler\GetStateByIdHandlerFactory;
use Academy\State\Handler\PostStateHandler;
use Academy\State\Handler\PostStateHandlerFactory;
use Academy\State\Handler\PutStateHandler;
use Academy\State\Handler\PutStateHandlerFactory;
use Academy\State\Middleware\PostStateMiddleware;
use Academy\State\Middleware\PostStateMiddlewareFactory;
use Academy\State\Middleware\PutStateMiddleware;
use Academy\State\Middleware\PutStateMiddlewareFactory;
use Academy\State\Service\DeleteStateService;
use Academy\State\Service\DeleteStateServiceFactory;
use Academy\State\Service\GetStateService;
use Academy\State\Service\GetStateServiceFactory;
use Academy\State\Service\PostStateService;
use Academy\State\Service\PostStateServiceFactory;
use Academy\State\Service\PutStateService;
use Academy\State\Service\PutStateServiceFactory;
use Academy\User\Handler\GetUserByIdHandler;
use Academy\User\Handler\GetUserByIdHandlerFactory;
use Academy\User\Service\GetUserService;
use Academy\User\Service\GetUserServiceFactory;
use Mezzio\Application;

/**
 * The configuration provider for the City module
 *
 * @see https://docs.zendframework.com/zend-component-installer/
 */
class ConfigProvider
{
    /**
     * Returns the configuration array
     *
     * To add a bit of a structure, each section is defined in a separate
     * method which returns an array with its configuration.
     */
    public function __invoke(): array
    {
        return [
            "dependencies" => $this->getDependencies(),
        ];
    }

    /**
     * Returns the container dependencies
     */
    public function getDependencies(): array
    {
        return [
            'delegators' => [
                Application::class => [RoutesDelegator::class]
            ],

            'invokables' => [],

            'factories' => [
                # City
                # Handler
                DeleteCityHandler::class => DeleteCityHandlerFactory::class,
                DeleteStateHandler::class => DeleteStateHandlerFactory::class,
                GetAllCityHandler::class => GetAllCityHandlerFactory::class,
                GetCityByIdHandler::class => GetCityByIdHandlerFactory::class,
                PostCityHandler::class => PostCityHandlerFactory::class,
                PutCityHandler::class => PutCityHandlerFactory::class,

                # Service
                DeleteCityService::class => DeleteCityServiceFactory::class,
                DeleteStateService::class => DeleteStateServiceFactory::class,
                GetCityService::class => GetCityServiceFactory::class,
                PostCityService::class => PostCityServiceFactory::class,
                PutCityService::class => PutCityServiceFactory::class,

                # Middleware
                PostCityMiddleware::class => PostCityMiddlewareFactory::class,
                PutCityMiddleware::class => PutCityMiddlewareFactory::class,

                # State
                # Handler
                GetAllStateHandler::class => GetAllStateHandlerFactory::class,
                GetStateByIdHandler::class => GetStateByIdHandlerFactory::class,
                PostStateHandler::class => PostStateHandlerFactory::class,
                PutStateHandler::class => PutStateHandlerFactory::class,

                # Service
                GetStateService::class => GetStateServiceFactory::class,
                PostStateService::class => PostStateServiceFactory::class,
                PutStateService::class => PutStateServiceFactory::class,

                # Middleware
                PostStateMiddleware::class => PostStateMiddlewareFactory::class,
                PutStateMiddleware::class => PutStateMiddlewareFactory::class,

                # User
                GetUserService::class => GetUserServiceFactory::class,
                GetUserByIdHandler::class => GetUserByIdHandlerFactory::class,
            ],
        ];
    }

    /**
     * Returns the templates configuration
     */
    public function getTemplates(): array
    {
        return [
            'paths' => [],
        ];
    }
}
