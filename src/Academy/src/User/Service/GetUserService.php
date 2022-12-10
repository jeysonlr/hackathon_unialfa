<?php

declare(strict_types=1);

namespace Academy\User\Service;

use Academy\User\Entity\User;
use Academy\User\Repository\UserRepository;
use Academy\User\Exception\UserDatabaseException;

class GetUserService implements GetUserServiceInterface
{
    /**
     * @var UserRepository
     */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * @return array|null
     * @throws UserDatabaseException
     */
    public function getAllUsers(): ?array
    {
        return $this->userRepository->findAllUsers();
    }

    /**
     * @param int $id
     *
     * @return User|null
     * @throws UserDatabaseException
     */
    public function getUserById(int $id): ?User
    {
        return $this->userRepository->findByUserId($id);
    }
}
