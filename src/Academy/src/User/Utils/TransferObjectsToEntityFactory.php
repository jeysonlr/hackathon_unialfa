<?php

declare(strict_types=1);

namespace Academy\User\Utils;

class TransferObjectsToEntityFactory
{
    public function __invoke(): TransferObjectsToEntity
    {
        return new TransferObjectsToEntity();
    }
}
