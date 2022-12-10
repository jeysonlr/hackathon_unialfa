<?php

declare(strict_types=1);

namespace Academy\City\Service;

use Academy\City\Dto\CityDto;
use Academy\City\Entity\City;
use App\Exception\SQLFileNotFoundException;
use Academy\State\Service\GetStateService;
use Academy\City\Repository\CityRepository;
use Academy\City\Exception\CityDatabaseException;
use Academy\State\Exception\StateDatabaseException;

class GetCityService
{
    /**
     * @var CityRepository
     */
    private $cityRepository;

    /**
     * @var GetStateService
     */
    private $getStateService;

    public function __construct(
        CityRepository $cityRepository,
        GetStateService $getStateService
    ) {
        $this->cityRepository = $cityRepository;
        $this->getStateService = $getStateService;
    }

    /**
     * @param int $cityId
     * @return array|null
     * @throws CityDatabaseException
     */
    public function getCityById(int $cityId): ?City
    {
        return $this->cityRepository->findByCityId($cityId);
    }

    /**
     * @return array|null
     * @throws CityDatabaseException
     * @throws StateDatabaseException
     */
    public function getAllCitys(): ?array
    {
        $allCitys = $this->cityRepository->findAllCitys();

        $allCityResult = [];
        foreach ($allCitys as $key => $value) {
            $stateName = $this->getStateService->getStateById($value->getEstadoid());
            $cityDto = new CityDto();
            $cityDto->setCidadeid($value->getCidadeid());
            $cityDto->setNome($value->getNome());
            $cityDto->setEstadoid($value->getEstadoid());
            $cityDto->setEstadonome($stateName->getNome());
            $cityDto->setDatacriacao($value->getDatacriacao());
            $cityDto->setDataalteracao($value->getDataalteracao());
            array_push($allCityResult, $cityDto);
        }

        return $allCityResult;
    }

    /**
     * @param string $name
     * @return array|null
     * @throws CityDatabaseException
     * @throws SQLFileNotFoundException
     */
    public function getCityByName(string $name): ?array
    {
        return $this->cityRepository->findCityByName($name);
    }
}
