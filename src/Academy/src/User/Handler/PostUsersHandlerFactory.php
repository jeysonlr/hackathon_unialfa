<?php

declare(strict_types=1);

namespace Academy\User\Handler;

use Psr\Container\ContainerInterface;

class PostUsersHandlerFactory
{
    public function __invoke(ContainerInterface $container): PostUsersHandler
    {
        return new PostUsersHandler();
    }
}
