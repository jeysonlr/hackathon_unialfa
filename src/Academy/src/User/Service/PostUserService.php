<?php

declare(strict_types=1);

namespace Academy\User\Service;

use Exception;
use Academy\User\DTO\User;
use App\Util\Enum\StatusHttp;
use Academy\User\DTO\UserResponse;
use Academy\User\Repository\UserRepository;
use Academy\User\Utils\TransferObjectsToEntity;
use Academy\User\Exception\UserDatabaseException;
use Academy\User\Exception\UsersNotFoundException;

class PostUserService implements PostUserServiceInterface
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
     * @param User $userDto
     *
     * @return UserResponse
     * @throws UserDatabaseException
     * @throws UsersNotFoundException
     */
    public function postUser(User $userDto): UserResponse
    {
        try {
            $userEntity = $this->transferObjectToEntity->transferDtoToEntity($userDto);

            $userEntity->setPassword(password_hash($userEntity->getPassword(), PASSWORD_DEFAULT));

            $userRepository = $this->userRepository->insertUser($userEntity);

            return $this->transferObjectToEntity->transferEntityToDto($userRepository);
        } catch (UserDatabaseException $e) {
            throw $e;
        } catch (Exception $e) {
            throw new UsersNotFoundException(
                StatusHttp::NOT_FOUND,
                $e->getMessage()
            );
        }
    }
}
