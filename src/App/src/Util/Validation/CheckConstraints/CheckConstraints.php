<?php

declare(strict_types=1);

namespace App\Util\Validation\CheckConstraints;

use App\Util\Enum\StatusHttp;
use App\Entity\BaseEntityInterface;
use App\Util\Validation\CheckConstraints\CheckConstraintsInterface;
use App\Util\Validation\CheckConstraints\Exception\BaseEntityException;
use App\Util\Validation\CheckConstraints\Exception\BaseEntityViolationsException;

class CheckConstraints implements CheckConstraintsInterface
{
    /**
     * Check the object/entity
     * @param BaseEntityInterface|null $entity
     * @param $messageError
     * @throws BaseEntityException
     */
    public static function checkBaseEntity(?BaseEntityInterface $entity, ?string $messageError = null): void
    {
        if (empty($entity)) {
            $messageError = (!empty($messageError) ? $messageError : "A entidade está vazia!");
            throw new BaseEntityException(StatusHttp::BAD_REQUEST, $messageError);
        }
    }

    /**
     * Check attribute/property annotation constraint violations
     * CheckConstraints entity
     * @param array $constraints
     * @throws BaseEntityViolationsException
     */
    public static function checkBaseEntityConstraints(array $constraints): void
    {
        if (count($constraints) > 0) {
            throw new BaseEntityViolationsException(
                StatusHttp::BAD_REQUEST,
                null,
                null,
                null,
                $constraints
            );
        }
    }

    /**
     * Check an array of constraints/errors
     * @param int $statusCode
     * @param array ...$constraints
     * @throws BaseEntityViolationsException
     */
    public function checkArrayConstraints(int $statusCode, ...$constraints): void
    {
        foreach ($constraints as $index => $constraint) {
            if (!empty($constraint)) {
                throw new BaseEntityViolationsException(
                    $statusCode,
                    $constraint[$index]->getMessageError(),
                    null,
                    null,
                    $constraint[$index]
                );
            }
        }
    }
}
