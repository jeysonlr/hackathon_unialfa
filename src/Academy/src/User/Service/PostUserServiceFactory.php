<?php

declare(strict_types=1);

namespace Academy\User\Service;

use Academy\User\Entity\User;
use Doctrine\ORM\EntityManager;
use Psr\Container\ContainerInterface;
use Academy\User\Utils\TransferObjectsToEntity;

class PostUserServiceFactory
{
    public function __invoke(ContainerInterface $container): PostUserService
    {
        $entityManager = $container->get(EntityManager::class);
        $userRepository = $entityManager->getRepository(User::class);
        $tranferObjectsToEntity = $container->get(TransferObjectsToEntity::class);
        return new PostUserService(
            $userRepository,
            $tranferObjectsToEntity
        );
    }
}
