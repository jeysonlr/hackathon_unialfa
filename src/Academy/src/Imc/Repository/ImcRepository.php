<?php

declare(strict_types=1);

namespace Academy\Imc\Repository;

use Academy\Imc\Entity\Imc;
use Academy\Imc\Exception\ImcDatabaseException;
use App\Exception\SQLFileNotFoundException;
use App\Util\ReadArchive\ReadArchiveSQL;
use Exception;
use App\Util\Enum\StatusHttp;
use App\Util\Enum\ErrorMessage;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;

final class ImcRepository extends EntityRepository
{
    /**
     * @param Imc $imc
     * @throws ImcDatabaseException
     */
    public function register(Imc $imc): void
    {
        try {
            $this->getEntityManager()->persist($imc);
            $this->getEntityManager()->flush();
        } catch (Exception $e) {
            throw new ImcDatabaseException(
                StatusHttp::INTERNAL_SERVER_ERROR,
                ErrorMessage::ERROR_INSERTING_RECORD,
                $e->getMessage()
            );
        }
    }

    /**
     * @param int $imcId
     * @return Imc|object|null
     * @throws ImcDatabaseException
     */
    public function findById(int $imcId): ?Imc
    {
        try {
            return $this->getEntityManager()->getRepository(Imc::class)->findOneBy(['id' => $imcId]);
        } catch (Exception $e) {
            throw new ImcDatabaseException(
                StatusHttp::INTERNAL_SERVER_ERROR,
                ErrorMessage::ERROR_QUERY_A_RECORD . "id " . $imcId,
                $e->getMessage()
            );
        }
    }

    /**
     * @return Imc[]|array|null
     * @throws ImcDatabaseException
     */
    public function all(): ?array
    {
        try {
            return $this->getEntityManager()->getRepository(Imc::class)->findAll();
        } catch (Exception $e) {
            throw new ImcDatabaseException(
                StatusHttp::INTERNAL_SERVER_ERROR,
                ErrorMessage::ERROR_QUERY_ALL_RECORD,
                $e->getMessage()
            );
        }
    }

    /**
     * @param int $profissionalId
     * @return array
     * @throws ImcDatabaseException
     * @throws SQLFileNotFoundException
     */
    public function findResultByProfissionalId(int $profissionalId): array
    {
        try {
            $resultSet = (new ResultSetMapping())
                ->addScalarResult('nome', 'nome')
                ->addScalarResult('cpf', 'cpf')
                ->addScalarResult('qtd', 'qtd');

            $sql = (new ReadArchiveSQL())->readArchive('IMC', 'resultByProfissional');
            $query = $this->getEntityManager()->createNativeQuery($sql, $resultSet);
            $query->setParameter('id', $profissionalId);

            return $query->getResult();
        } catch (SQLFileNotFoundException $e) {
            throw $e;
        } catch (Exception $e) {
            throw new ImcDatabaseException(
                StatusHttp::INTERNAL_SERVER_ERROR,
                ErrorMessage::ERROR_QUERY_A_RECORD,
                $e->getMessage()
            );
        }
    }
}
