<?php

declare(strict_types=1);

namespace Academy\State\Service;

use App\Util\Enum\StatusHttp;
use App\Util\Enum\ErrorMessage;
use Academy\State\Exception\StateDatabaseException;
use Academy\State\Exception\StateIdException;
use Academy\State\Repository\StateRepository;

class DeleteStateService
{
    /**
     * @var StateRepository
     */
    private $stateRepository;

    /**
     * @var GetStateService
     */
    private $getStateService;

    public function __construct(
        StateRepository $stateRepository,
        GetStateService $getStateService
    ) {
        $this->stateRepository = $stateRepository;
        $this->getStateService = $getStateService;
    }

    /**
     * @param int $stateId
     * @throws StateIdException
     * @throws StateDatabaseException
     */
    public function deleteState(int $stateId): void
    {
        $state = $this->getStateService->getStateById($stateId);

        if ($state) {
            $this->stateRepository->deleteState($state);
        } else {
            throw new StateIdException(
                StatusHttp::NOT_FOUND,
                sprintf(
                    ErrorMessage::ERROR_REGISTER_NOT_FOUND,
                    $stateId
                )
            );
        }
    }
}
