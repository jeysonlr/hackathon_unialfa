<?php

namespace Academy\Imc\Service;

use Academy\Imc\DTO\ImcResponse;
use Academy\Imc\Entity\Imc;
use Academy\Imc\Exception\ImcDatabaseException;
use Academy\Imc\Repository\ImcRepository;

final class ImcService implements ImcServiceInterface
{
    /**
     * @var ImcRepository
     */
    private $repository;

    public function __construct(ImcRepository $repository)
    {
        $this->repository = $repository;
    }

    /**
     * @param Imc $imc
     * @throws ImcDatabaseException
     */
    public function register(Imc $imc): void
    {
        $this->repository->register($imc);
    }

    /**
     * @return array|ImcResponse[]
     * @throws ImcDatabaseException
     */
    public function findAll(): array
    {
        $imcResults = $this->repository->all();

        return array_map(function ($imc) {
            return $this->imcEntityToImcResponse($imc);
        }, $imcResults);
    }

    /**
     * @param int $id
     * @return ImcResponse
     * @throws ImcDatabaseException
     */
    public function findById(int $id): ImcResponse
    {
        $imc = $this->repository->findById($id);

        return $this->imcEntityToImcResponse($imc);
    }

    /**
     * @param Imc $imc
     * @return ImcResponse
     */
    private function imcEntityToImcResponse(Imc $imc): ImcResponse
    {
        return ImcResponse::build(
            $imc->getId(),
            $imc->getClientId(),
            $imc->getProfissionalId(),
            $imc->getWeight(),
            $imc->getHeight(),
            $imc->getCreatedAt()
        );
    }
}