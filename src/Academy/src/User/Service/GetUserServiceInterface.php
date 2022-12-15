<?php

declare(strict_types=1);

namespace Academy\User\Service;

use Academy\User\DTO\UserResponse;
use Academy\User\Entity\User;
use Academy\User\Exception\UserDatabaseException;

interface GetUserServiceInterface
{
    /**
     * @return array|null
     * @throws UserDatabaseException
     */
    public function getAllUsers(): ?array;

    /**
     * @param int $id
     * @return UserResponse|null
     * @throws UserDatabaseException
     */
    public function getUserById(int $id): ?UserResponse;

    /**
     * @param string $cpf
     *
     * @return UserResponse|null
     * @throws UserDatabaseException
     */
    public function getUserByCpf(string $cpf): ?UserResponse;

    /**
     * @param string $cpf
     *
     * @return User|null
     * @throws UserDatabaseException
     */
    public function getUserPasswordByCpf(string $cpf): ?User;
}
