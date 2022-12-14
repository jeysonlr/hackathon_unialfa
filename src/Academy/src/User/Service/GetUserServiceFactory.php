<?php

declare(strict_types=1);

namespace Academy\User\Service;

use Academy\User\Entity\User;
use Academy\User\Utils\TransferObjectsToEntity;
use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;

class GetUserServiceFactory
{
    public function __invoke(ContainerInterface $container): GetUserService
    {
        $entityManager = $container->get(EntityManager::class);
        $userRepository = $entityManager->getRepository(User::class);
        $tranferObjectsToEntity = $container->get(TransferObjectsToEntity::class);
        return new GetUserService(
            $userRepository,
            $tranferObjectsToEntity
        );
    }
}
