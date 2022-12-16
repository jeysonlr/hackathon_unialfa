<?php

declare(strict_types=1);

namespace Academy;

use Academy\Authentication\Container\JWTFactory;
use Academy\Authentication\Middleware\AuthenticationTokenMiddleware;
use Academy\Authentication\Middleware\AuthenticationTokenMiddlewareFactory;
use Academy\Authentication\Service\AuthenticationTokenService;
use Academy\Authentication\Service\AuthenticationTokenServiceFactory;
use Mezzio\Application;
use Academy\User\Service\GetUserService;
use Academy\User\Service\PostUserService;
use Academy\User\Handler\PostUsersHandler;
use Academy\User\Handler\GetAllUsersHandler;
use Academy\User\Handler\GetUserByIdHandler;
use Academy\User\Utils\TransferObjectsToEntity;
use Academy\User\Middleware\PostUserMiddleware;
use Academy\User\Service\GetUserServiceFactory;
use Academy\User\Service\PostUserServiceFactory;
use Academy\User\Handler\PostUsersHandlerFactory;
use Academy\User\Handler\GetUserByIdHandlerFactory;
use Academy\User\Handler\GetAllUsersHandlerFactory;
use Academy\User\Utils\TransferObjectsToEntityFactory;
use Academy\User\Middleware\PostUserMiddlewareFactory;
use Academy\Authentication\Handler\AuthenticationTokenHandler;
use Academy\Authentication\Middleware\ValidationLoginMiddleware;
use Academy\Authentication\Handler\AuthenticationTokenHandlerFactory;
use Academy\Authentication\Middleware\ValidationLoginMiddlewareFactory;

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
                # User
                GetUserService::class => GetUserServiceFactory::class,
                GetUserByIdHandler::class => GetUserByIdHandlerFactory::class,
                GetAllUsersHandler::class => GetAllUsersHandlerFactory::class,

                PostUsersHandler::class => PostUsersHandlerFactory::class,
                PostUserMiddleware::class => PostUserMiddlewareFactory::class,

                PostUserService::class => PostUserServiceFactory::class,
                TransferObjectsToEntity::class => TransferObjectsToEntityFactory::class,

                # Authentication
                ValidationLoginMiddleware::class => ValidationLoginMiddlewareFactory::class,
                AuthenticationTokenHandler::class => AuthenticationTokenHandlerFactory::class,
                AuthenticationTokenService::class => AuthenticationTokenServiceFactory::class,
                JWTFactory::class => JWTFactory::class,

                AuthenticationTokenMiddleware::class => AuthenticationTokenMiddlewareFactory::class,
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
