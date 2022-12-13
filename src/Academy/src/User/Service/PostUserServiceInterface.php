<?php

declare(strict_types=1);

namespace Academy\User\Service;

use Academy\User\DTO\User;
use Academy\User\DTO\UserResponse;
use Academy\User\Exception\UserDatabaseException;
use Academy\User\Exception\UsersNotFoundException;

interface PostUserServiceInterface
{
    /**
     * @param User $userDto
     *
     * @return UserResponse
     * @throws UserDatabaseException
     * @throws UsersNotFoundException
     */
    public function postUser(User $userDto): UserResponse;
}
