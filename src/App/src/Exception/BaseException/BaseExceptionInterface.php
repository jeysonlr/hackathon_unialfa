<?php

declare(strict_types=1);

namespace App\Exception\BaseException;

use App\DTO\Response\ResponseError;

/**
 * Interface BaseExceptionInterface
 * @package Exception
 */
interface BaseExceptionInterface
{
    /**
     * @return array
     */
    public function createCustomError(): array;

    /**
     * @param $messageError
     * @return ResponseError
     */
    public function errorResponse($messageError): ResponseError;
}
