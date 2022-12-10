<?php

declare(strict_types=1);

namespace App\Util\Validation\CheckConstraints;

use App\Entity\BaseEntityInterface;

interface CheckConstraintsInterface
{
    /**
     * @param BaseEntityInterface|null $entity
     * @param string|null $messageError
     */
    public static function checkBaseEntity(?BaseEntityInterface $entity, ?string $messageError = null): void;

    /**
     * @param array $constraints
     */
    public static function checkBaseEntityConstraints(array $constraints): void;
}