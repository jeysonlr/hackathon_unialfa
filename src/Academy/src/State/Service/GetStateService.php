<?php

declare(strict_types=1);

namespace Academy\State\Service;

use Academy\State\Dto\StateDto;
use Academy\State\Entity\State;
use App\Exception\SQLFileNotFoundException;
use Academy\State\Repository\StateRepository;
use Academy\State\Exception\StateDatabaseException;

class GetStateService
{
    /**
     * @var StateRepository
     */
    private $stateRepository;

    public function __construct(
        StateRepository $stateRepository
    ) {
        $this->stateRepository = $stateRepository;
    }

    /**
     * @param int $stateId
     * @return StateDto|null
     * @throws SQLFileNotFoundException
     * @throws StateDatabaseException
     */
    public function getStateAndCitysById(int $stateId): ?StateDto
    {
        $states = $this->stateRepository->findByStateId($stateId);

        $statesDto = new StateDto();
        $statesDto->setEstadoid($states->getEstadoid());
        $statesDto->setNome($states->getNome());
        $statesDto->setAbreviacao($states->getAbreviacao());
        $statesDto->setDatacriacao($states->getDatacriacao());
        $statesDto->setDataalteracao($states->getDataalteracao());
        $statesDto->setCidades($this->getCityByState($stateId));

        return $statesDto;
    }

    /**
     * @param int $stateId
     * @return State|null
     * @throws StateDatabaseException
     */
    public function getStateById(int $stateId): ?State
    {
        return $this->stateRepository->findByStateId($stateId);
    }

    /**
     * @return array|null
     * @throws StateDatabaseException
     */
    public function getAllStates(): ?array
    {
        return $this->stateRepository->findAllStates();
    }

    /**
     * @param string $stateName
     * @return array|null
     * @throws StateDatabaseException
     * @throws SQLFileNotFoundException
     */
    public function getStateByName(string $stateName): ?array
    {
        return $this->stateRepository->findStateByName($stateName);
    }

    /**
     * @param int $stateId
     * @return array|null
     * @throws SQLFileNotFoundException
     * @throws StateDatabaseException
     */
    public function getCityByState(int $stateId): ?array
    {
        return $this->stateRepository->findCityByState($stateId);
    }
}
