<?php

declare(strict_types=1);

namespace Academy\State\Service;

use Doctrine\ORM\EntityManager;
use Academy\State\Entity\State;
use Psr\Container\ContainerInterface;

class PostStateServiceFactory
{
    public function __invoke(ContainerInterface $container): PostStateService
    {
        $entityManager = $container->get(EntityManager::class);
        $stateRepository = $entityManager->getRepository(State::class);
        return new PostStateService(
            $stateRepository
        );
    }
}
