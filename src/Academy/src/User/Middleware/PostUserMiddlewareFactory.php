<?php

declare(strict_types=1);

namespace Academy\User\Middleware;

use App\Util\Serialize\SerializeUtil;
use App\Util\Validation\ValidationService;
use Psr\Container\ContainerInterface;

class PostUserMiddlewareFactory
{
    public function __invoke(ContainerInterface $container): PostUserMiddleware
    {
        $jms = $container->get(SerializeUtil::class);
        $validationService = $container->get(ValidationService::class);
        return new PostUserMiddleware(
            $jms,
            $validationService
        );
    }
}
