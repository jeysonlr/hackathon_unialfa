<?php

declare(strict_types=1);

namespace Academy\City\Repository;

use Exception;
use App\Util\Enum\StatusHttp;
use App\Util\Enum\ErrorMessage;
use Academy\City\Entity\City;
use Doctrine\ORM\EntityRepository;
use Doctrine\ORM\Query\ResultSetMapping;
use App\Util\ReadArchive\ReadArchiveSQL;
use App\Exception\SQLFileNotFoundException;
use Academy\City\Exception\CityDatabaseException;

class CityRepository extends EntityRepository
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
     * @param City $city
     * @return City
     * @throws CityDatabaseException
     */
    public function insertCity(City $city): City
    {
        try {
            $this->getEntityManager()->persist($city);
            $this->getEntityManager()->flush();
            return $city;
        } catch (Exception $e) {
            throw new CityDatabaseException(
                StatusHttp::INTERNAL_SERVER_ERROR,
                ErrorMessage::ERROR_INSERTING_RECORD,
                $e->getMessage()
            );
        }
    }

    /**
     * @param City $city
     * @return City
     * @throws CityDatabaseException
     */
    public function updateCity(City $city): City
    {
        try {
            $this->getEntityManager()->merge($city);
            $this->getEntityManager()->flush();
            return $city;
        } catch (Exception $e) {
            throw new CityDatabaseException(
                StatusHttp::INTERNAL_SERVER_ERROR,
                ErrorMessage::ERROR_REGISTRY_CHANGE,
                $e->getMessage()
            );
        }
    }

    /**
     * @param City $city
     * @throws CityDatabaseException
     */
    public function deleteCity(City $city): void
    {
        try {
            $this->getEntityManager()->remove($city);
            $this->getEntityManager()->flush();
        } catch (Exception $e) {
            throw new CityDatabaseException(
                StatusHttp::INTERNAL_SERVER_ERROR,
                ErrorMessage::ERROR_DELETING_RECORD,
                $e->getMessage()
            );
        }
    }

    /**
     * @param int $cityId
     * @return City|null
     * @throws CityDatabaseException
     */
    public function findByCityId(int $cityId): ?City
    {
        try {
            return $this->getEntityManager()->getRepository(City::class)
                ->findOneBy(['cidadeid' => $cityId]);
        } catch (Exception $e) {
            throw new CityDatabaseException(
                StatusHttp::INTERNAL_SERVER_ERROR,
                ErrorMessage::ERROR_QUERY_A_RECORD . "id " . $cityId,
                $e->getMessage()
            );
        }
    }

    /**
     * @return array|null
     * @throws CityDatabaseException
     */
    public function findAllCitys(): ?array
    {
        try {
            return $this->getEntityManager()->getRepository(City::class)->findAll();
        } catch (Exception $e) {
            throw new CityDatabaseException(
                StatusHttp::INTERNAL_SERVER_ERROR,
                ErrorMessage::ERROR_QUERY_ALL_RECORD,
                $e->getMessage()
            );
        }
    }

    /**
     * @param string $name
     * @return array|null
     * @throws CityDatabaseException
     * @throws SQLFileNotFoundException
     */
    public function findCityByName(string $name): ?array
    {
        try {
            $this->setInstance();
            $this->resultSetMapping->addScalarResult('cidadeid', 'cidadeid');
            $this->resultSetMapping->addScalarResult('nome', 'nome');
            $this->resultSetMapping->addScalarResult('estadoid', 'estadoid');
            $this->resultSetMapping->addScalarResult('datacriacao', 'datacriacao');
            $this->resultSetMapping->addScalarResult('dataalteracao', 'dataalteracao');
            $sql = $this->readSQL->readArchive('City', 'SELECT_CITY_BY_NAME');
            $query = $this->getEntityManager()->createNativeQuery($sql, $this->resultSetMapping);
            $query->setParameter('nome', $name);
            return $query->getOneOrNullResult();
        } catch (SQLFileNotFoundException $e) {
            throw $e;
        } catch (Exception $e) {
            throw new CityDatabaseException(
                StatusHttp::INTERNAL_SERVER_ERROR,
                "Ocorreu um erro ao buscar dados de cidade!",
                $e->getMessage()
            );
        }
    }
}
