<?php

declare(strict_types=1);

namespace Academy\State\Handler;

use Academy\State\Service\PostStateService;
use Psr\Container\ContainerInterface;

class PostStateHandlerFactory
{
    public function __invoke(ContainerInterface $container): PostStateHandler
    {
        $postState = $container->get(PostStateService::class);
        return new PostStateHandler(
            $postState
        );
    }
}
