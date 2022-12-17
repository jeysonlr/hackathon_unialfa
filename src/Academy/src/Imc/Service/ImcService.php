<?php

namespace Academy\Imc\Service;

use Academy\Imc\DTO\ImcCollection;
use Academy\Imc\DTO\ImcResponse;
use Academy\Imc\Entity\Imc;
use Academy\Imc\Exception\ImcDatabaseException;
use Academy\Imc\Repository\ImcRepository;
use App\Exception\SQLFileNotFoundException;

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
     * @return ImcCollection
     * @throws ImcDatabaseException
     */
    public function findAll(): ImcCollection
    {
        $imcResults = $this->repository->all();

        return new ImcCollection(
            array_map(function ($imc) {
                return $this->imcEntityToImcResponse($imc);
            }, $imcResults)
        );
    }

    /**
     * @param int $profissionalId
     * @return array
     * @throws ImcDatabaseException
     * @throws SQLFileNotFoundException
     */
    public function findResultByProfissionalId(int $profissionalId): array
    {
        return $this->repository->findResultByProfissionalId($profissionalId);
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
            $imc->getResult(),
            $imc->getCreatedAt()
        );
    }
}