<?php

namespace Academy\Imc\Service;

use Academy\Imc\DTO\ImcResponse;
use Academy\Imc\Entity\Imc;

interface ImcServiceInterface
{
    /**
     * @param Imc $imc
     */
    public function register(Imc $imc): void;

    /**
     * @return ImcResponse[]
     */
    public function findAll(): array;

    /**
     * @param int $id
     * @return ImcResponse
     */
    public function findById(int $id): ImcResponse;
}