<?php

declare(strict_types=1);

namespace Academy\User\Handler;

use Psr\Container\ContainerInterface;
use Academy\User\Service\PostUserService;

class PostUsersHandlerFactory
{
    public function __invoke(ContainerInterface $container): PostUsersHandler
    {
        $postUserService = $container->get(PostUserService::class);
        return new PostUsersHandler(
            $postUserService
        );
    }
}
