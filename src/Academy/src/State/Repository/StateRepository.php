<?php

declare(strict_types=1);

namespace Academy\State\Repository;

use Exception;
use App\Util\Enum\StatusHttp;
use App\Util\Enum\ErrorMessage;
use Doctrine\ORM\EntityRepository;
use Academy\State\Entity\State;
use App\Util\ReadArchive\ReadArchiveSQL;
use Doctrine\ORM\Query\ResultSetMapping;
use App\Exception\SQLFileNotFoundException;
use Academy\State\Exception\StateDatabaseException;

class StateRepository extends EntityRepository
{
    /**
     * @var ResultSetMapping
     */
    private $resultSetMapping;

    /**
     * @var ReadArchiveSQL
     */
    private $readSQL;

    private function setInstance(): void
    {
        $this->resultSetMapping = new ResultSetMapping();
        $this->readSQL = new ReadArchiveSQL();
    }

    /**
     * @param State $state
     * @return State
     * @throws StateDatabaseException
     */
    public function insertState(State $state): State
    {
        try {
            $this->getEntityManager()->persist($state);
            $this->getEntityManager()->flush();
            return $state;
        } catch (Exception $e) {
            throw new StateDatabaseException(
                StatusHttp::INTERNAL_SERVER_ERROR,
                ErrorMessage::ERROR_INSERTING_RECORD,
                $e->getMessage()
            );
        }
    }

    /**
     * @param State $state
     * @return State
     * @throws StateDatabaseException
     */
    public function updateState(State $state): State
    {
        try {
            $this->getEntityManager()->merge($state);
            $this->getEntityManager()->flush();
            return $state;
        } catch (Exception $e) {
            throw new StateDatabaseException(
                StatusHttp::INTERNAL_SERVER_ERROR,
                ErrorMessage::ERROR_REGISTRY_CHANGE,
                $e->getMessage()
            );
        }
    }

    /**
     * @param State $state
     * @throws StateDatabaseException
     */
    public function deleteState(State $state): void
    {
        try {
            $this->getEntityManager()->remove($state);
            $this->getEntityManager()->flush();
        } catch (Exception $e) {
            throw new StateDatabaseException(
                StatusHttp::INTERNAL_SERVER_ERROR,
                ErrorMessage::ERROR_DELETING_RECORD,
                $e->getMessage()
            );
        }
    }

    /**
     * @param int $stateId
     * @return State|null
     * @throws StateDatabaseException
     */
    public function findByStateId(int $stateId): ?State
    {
        try {
            return $this->getEntityManager()->getRepository(State::class)
                ->findOneBy(['estadoid' => $stateId]);
        } catch (Exception $e) {
            throw new StateDatabaseException(
                StatusHttp::INTERNAL_SERVER_ERROR,
                ErrorMessage::ERROR_QUERY_A_RECORD . "id " . $stateId,
                $e->getMessage()
            );
        }
    }

    /**
     * @return array|null
     * @throws StateDatabaseException
     */
    public function findAllStates(): ?array
    {
        try {
            return $this->getEntityManager()->getRepository(State::class)->findAll();
        } catch (Exception $e) {
            throw new StateDatabaseException(
                StatusHttp::INTERNAL_SERVER_ERROR,
                ErrorMessage::ERROR_QUERY_ALL_RECORD,
                $e->getMessage()
            );
        }
    }

    /**
     * @param string $name
     * @return array|null
     * @throws SQLFileNotFoundException
     * @throws StateDatabaseException
     */
    public function findStateByName(string $name): ?array
    {
        try {
            $this->setInstance();
            $this->resultSetMapping->addScalarResult('estadoid', 'estadoid');
            $this->resultSetMapping->addScalarResult('nome', 'nome');
            $this->resultSetMapping->addScalarResult('abreviacao', 'abreviacao');
            $this->resultSetMapping->addScalarResult('datacriacao', 'datacriacao');
            $this->resultSetMapping->addScalarResult('dataalteracao', 'dataalteracao');
            $sql = $this->readSQL->readArchive('State', 'SELECT_STATE_BY_NAME');
            $query = $this->getEntityManager()->createNativeQuery($sql, $this->resultSetMapping);
            $query->setParameter('nome', $name);
            return $query->getOneOrNullResult();
        } catch (SQLFileNotFoundException $e) {
            throw $e;
        } catch (Exception $e) {
            throw new StateDatabaseException(
                StatusHttp::INTERNAL_SERVER_ERROR,
                "Ocorreu um erro ao buscar estado!",
                $e->getMessage()
            );
        }
    }

    /**
     * @param int $stateId
     * @return array|null
     * @throws SQLFileNotFoundException
     * @throws StateDatabaseException
     */
    public function findCityByState(int $stateId): ?array
    {
        try {
            $this->setInstance();
            $this->resultSetMapping->addScalarResult('cidade', 'cidade');
            $this->resultSetMapping->addScalarResult('estado', 'estado');
            $this->resultSetMapping->addScalarResult('uf', 'uf');
            $sql = $this->readSQL->readArchive('State', 'SELECT_CITY_BY_STATE');
            $query = $this->getEntityManager()->createNativeQuery($sql, $this->resultSetMapping);
            $query->setParameter('estadoid', $stateId);
            return $query->getResult();
        } catch (SQLFileNotFoundException $e) {
            throw $e;
        } catch (Exception $e) {
            throw new StateDatabaseException(
                StatusHttp::INTERNAL_SERVER_ERROR,
                "Ocorreu um erro ao buscar cidades por estado!",
                $e->getMessage()
            );
        }
    }
}
