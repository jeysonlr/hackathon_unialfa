<?php

declare(strict_types=1);

namespace Academy\User\Service;

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
     * @return User|null
     * @throws UserDatabaseException
     */
    public function getUserById(int $id): ?User;
}
