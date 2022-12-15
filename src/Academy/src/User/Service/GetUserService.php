<?php

declare(strict_types=1);

namespace Academy\User\Service;

use Academy\User\DTO\UserResponse;
use Academy\User\Entity\User;
use Academy\User\Repository\UserRepository;
use Academy\User\Utils\TransferObjectsToEntity;
use Academy\User\Exception\UserDatabaseException;

class GetUserService implements GetUserServiceInterface
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    /**
     * @var TransferObjectsToEntity
     */
    private $transferObjectToEntity;

    public function __construct(
        UserRepository $userRepository,
        TransferObjectsToEntity $transferObjectToEntity
    ) {
        $this->userRepository = $userRepository;
        $this->transferObjectToEntity = $transferObjectToEntity;
    }

    /**
     * @return array|null
     * @throws UserDatabaseException
     */
    public function getAllUsers(): ?array
    {
        $usersEmtity = $this->userRepository->findAllUsers();

        $newUser = array();
        foreach ($usersEmtity as $user) {
            $newUser[] = $this->transferObjectToEntity->transferEntityToDto($user);
        }
        return $newUser;
    }

    /**
     * @param int $id
     *
     * @return UserResponse|null
     * @throws UserDatabaseException
     */
    public function getUserById(int $id): ?UserResponse
    {
        $userRepository = $this->userRepository->findByUserId($id);
        return $this->transferObjectToEntity->transferEntityToDto($userRepository);
    }

    /**
     * @param string $cpf
     *
     * @return UserResponse|null
     * @throws UserDatabaseException
     */
    public function getUserByCpf(string $cpf): ?UserResponse
    {
        $userRepository = $this->userRepository->findByUserCpf($cpf);
        return $this->transferObjectToEntity->transferEntityToDto($userRepository);
    }

    /**
     * @param string $cpf
     *
     * @return User|null
     * @throws UserDatabaseException
     */
    public function getUserPasswordByCpf(string $cpf): ?User
    {
        return $this->userRepository->findByUserCpf($cpf);
    }
}
