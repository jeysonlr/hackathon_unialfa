<?php

declare(strict_types=1);

namespace Academy\User\Utils;

use Academy\User\DTO\User;
use Academy\User\DTO\UserResponse;
use Academy\User\Entity\User as UserEntity;

class TransferObjectsToEntity
{
    /**
     * @param UserEntity|null $userEntity
     *
     * @return UserResponse|null
     */
    public function transferEntityToDto(?UserEntity $userEntity): ?UserResponse
    {
        if(is_null($userEntity)) {
            return null;
        }

        $userDto = new UserResponse();
        $userDto->setId($userEntity->getId());
        $userDto->setName($userEntity->getName());
        $userDto->setCpf($userEntity->getCpf());
        $userDto->setType($userEntity->getType());
        return $userDto;
    }

    /**
     * @param User $userDto
     * @return UserEntity
     */
    public function transferDtoToEntity(User $userDto): UserEntity
    {
        $userEntity = new UserEntity();
        $userEntity->setName($userDto->getName());
        $userEntity->setCpf($userDto->getCpf());
        $userEntity->setPassword($userDto->getPassword());
        $userEntity->setType($userDto->getType());
        return $userEntity;
    }
}
