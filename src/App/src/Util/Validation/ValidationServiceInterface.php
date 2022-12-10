<?php

declare(strict_types=1);

namespace App\Util\Validation;

use App\Entity\BaseEntityInterface;

interface ValidationServiceInterface
{
    /**
     * validateEntity
     * @param  BaseEntityInterface $entity
     * @param  mixed $messageError
     *
     * @return void
     */
    public function validateEntity(?BaseEntityInterface $entity, ?array $groups = null, ?string $messageError = null): void;
}
