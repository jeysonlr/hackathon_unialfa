<?php

declare(strict_types=1);

namespace Academy\User\Repository;

use Exception;
use Academy\User\Entity\User;
use App\Util\Enum\StatusHttp;
use App\Util\Enum\ErrorMessage;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use Academy\User\Exception\UserDatabaseException;

class UserRepository extends EntityRepository
{
    /**
     * @var ResultSetMapping
     */
    private $resultSetMapping;

    private function setInstance(): void
    {
        $this->resultSetMapping = new ResultSetMapping();
    }

    /**
     * @param User $user
     * @return User
     * @throws UserDatabaseException
     */
    public function insertUser(User $user): User
    {
        try {
            $this->getEntityManager()->persist($user);
            $this->getEntityManager()->flush();
            return $user;
        } catch (Exception $e) {
            throw new UserDatabaseException(
                StatusHttp::INTERNAL_SERVER_ERROR,
                ErrorMessage::ERROR_INSERTING_RECORD,
                $e->getMessage()
            );
        }
    }

    /**
     * @param User $user
     * @return User
     * @throws UserDatabaseException
     */
    public function updateUser(User $user): User
    {
        try {
            $this->getEntityManager()->merge($user);
            $this->getEntityManager()->flush();
            return $user;
        } catch (Exception $e) {
            throw new UserDatabaseException(
                StatusHttp::INTERNAL_SERVER_ERROR,
                ErrorMessage::ERROR_REGISTRY_CHANGE,
                $e->getMessage()
            );
        }
    }

    /**
     * @param int $userId
     * @return User|object|null
     * @throws UserDatabaseException
     */
    public function findByUserId(int $userId): ?User
    {
        try {
            return $this->getEntityManager()->getRepository(User::class)
                ->findOneBy(['id' => $userId]);
        } catch (Exception $e) {
            throw new UserDatabaseException(
                StatusHttp::INTERNAL_SERVER_ERROR,
                ErrorMessage::ERROR_QUERY_A_RECORD . "id " . $userId,
                $e->getMessage()
            );
        }
    }

    /**
     * @return array|null
     * @throws UserDatabaseException
     */
    public function findAllUsers(): ?array
    {
        try {
            return $this->getEntityManager()->getRepository(User::class)->findAll();
        } catch (Exception $e) {
            throw new UserDatabaseException(
                StatusHttp::INTERNAL_SERVER_ERROR,
                ErrorMessage::ERROR_QUERY_ALL_RECORD,
                $e->getMessage()
            );
        }
    }

    /**
     * @param string $cpf
     * @return User|object|null
     * @throws UserDatabaseException
     */
    public function findByUserCpf(string $cpf): ?User
    {
        try {
            return $this->getEntityManager()->getRepository(User::class)
                ->findOneBy(['cpf' => $cpf]);
        } catch (Exception $e) {
            throw new UserDatabaseException(
                StatusHttp::INTERNAL_SERVER_ERROR,
                ErrorMessage::ERROR_QUERY_A_RECORD . "cpf " . $cpf,
                $e->getMessage()
            );
        }
    }
}
