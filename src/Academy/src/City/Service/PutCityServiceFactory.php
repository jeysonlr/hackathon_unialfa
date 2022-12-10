<?php

declare(strict_types=1);

namespace Academy\City\Service;

use Doctrine\ORM\EntityManager;
use Academy\City\Entity\City;
use Psr\Container\ContainerInterface;

class PutCityServiceFactory
{
    public function __invoke(ContainerInterface $container): PutCityService
    {
        $entityManager = $container->get(EntityManager::class);
        $cityRepository = $entityManager->getRepository(City::class);
        return new PutCityService(
            $cityRepository
        );
    }
}
