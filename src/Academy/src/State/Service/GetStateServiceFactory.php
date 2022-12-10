<?php

declare(strict_types=1);

namespace Academy\State\Service;

use Doctrine\ORM\EntityManager;
use Academy\State\Entity\State;
use Psr\Container\ContainerInterface;

class GetStateServiceFactory
{
    public function __invoke(ContainerInterface $container): GetStateService
    {
        $entityManager = $container->get(EntityManager::class);
        $stateRepository = $entityManager->getRepository(State::class);
        return new GetStateService(
            $stateRepository
        );
    }
}
