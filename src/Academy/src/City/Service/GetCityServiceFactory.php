<?php

declare(strict_types=1);

namespace Academy\City\Service;

use Doctrine\ORM\EntityManager;
use Academy\City\Entity\City;
use Psr\Container\ContainerInterface;
use Academy\State\Service\GetStateService;

class GetCityServiceFactory
{
    public function __invoke(ContainerInterface $container): GetCityService
    {
        $entityManager = $container->get(EntityManager::class);
        $cityRepository = $entityManager->getRepository(City::class);
        $getStateService = $container->get(GetStateService::class);
        return new GetCityService(
            $cityRepository,
            $getStateService
        );
    }
}
