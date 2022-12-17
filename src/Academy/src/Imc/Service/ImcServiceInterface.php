<?php

namespace Academy\Imc\Service;

use Academy\Imc\DTO\ImcCollection;
use Academy\Imc\DTO\ImcResponse;
use Academy\Imc\Entity\Imc;

interface ImcServiceInterface
{
    /**
     * @param Imc $imc
     */
    public function register(Imc $imc): void;

    /**
     * @return ImcCollection
     */
    public function findAll(): ImcCollection;

    /**
     * @param int $id
     * @return ImcResponse
     */
    public function findById(int $id): ImcResponse;

    /**
     * @param int $profissionalId
     * @return array
     */
    public function findResultByProfissionalId(int $profissionalId): array;
}