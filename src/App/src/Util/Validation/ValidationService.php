<?php

declare(strict_types=1);

namespace App\Util\Validation;

use App\Entity\BaseEntityInterface;
use Symfony\Component\Validator\Validation;
use App\Util\Validation\ValidationServiceInterface;
use App\Util\Validation\CheckConstraints\CheckConstraints;
use Symfony\Component\Validator\Validator\ValidatorInterface;
use App\Util\Validation\CheckConstraints\Exception\BaseEntityException;
use App\Util\Validation\CheckConstraints\Exception\BaseEntityViolationsException;

class ValidationService implements ValidationServiceInterface
{
    /**
     * @var ValidatorInterface
     */
    private $validationEntity;

    /**
     * @var array
     */
    private $violations = [];

    public function __construct()
    {
        $this->validationEntity = Validation::createValidatorBuilder()->enableAnnotationMapping()->getValidator();
    }

    /**
     * Validation of entities based on @BaseEntityInterface
     * @param BaseEntityInterface|null $entity
     * @param string|null $messageError
     * @throws BaseEntityException
     * @throws BaseEntityViolationsException
     */
    public function validateEntity(?BaseEntityInterface $entity, ?array $groups = null, ?string $messageError = null): void
    {
        CheckConstraints::checkBaseEntity($entity);
        $propertyConstraints = $this->validationEntity->validate($entity, $messageError, $groups);
        foreach ($propertyConstraints as $value) {
            if (!empty($value)) {
                array_push($this->violations, $value->getMessage());
            }
        }
        CheckConstraints::checkBaseEntityConstraints($this->violations);
    }
}
