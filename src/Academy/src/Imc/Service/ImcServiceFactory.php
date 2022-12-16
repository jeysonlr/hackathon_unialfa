<?php

namespace Academy\Imc\Service;

use Academy\Imc\Entity\Imc;
use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;

final class ImcServiceFactory
{
    public function __invoke(ContainerInterface $container): ImcService
    {
        $entityManager = $container->get(EntityManager::class);
        $imcRepository = $entityManager->getRepository(Imc::class);

        return new ImcService($imcRepository);
    }
}