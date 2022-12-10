<?php

declare(strict_types=1);

namespace App\Exception\BaseException;

use Exception;
use App\DTO\Response\ResponseError;
use App\Exception\BaseException\BaseExceptionInterface;

class BaseException extends Exception implements BaseExceptionInterface
{
    /**
     * @var null|string
     */
    protected $message;

    /**
     * @var null|string
     */
    private $internalMessage;

    /**
     * @var null|int
     */
    private $internalCode;

    /**
     * @var array
     */
    private $arrayMessageError = [];

    /**
     * @var int
     */
    private $countError = 0;

    /**
     * @var array
     */
    private $customError = [];

    public function __construct(
        int $statusCode,
        ?string $message = null,
        ?string $internalMessage = null,
        ?int $internalCode = null,
        ?array $arrayMessageError = null
    ) {
        $this->message = empty($message) ? "" : $message;
        $this->internalMessage = $internalMessage;
        $this->internalCode = $internalCode;
        $this->arrayMessageError = $arrayMessageError;
        parent::__construct($this->message, $statusCode);
    }

    /**
     * Create custom error response
     * @return array
     */
    public function createCustomError(): array
    {
        $this->countError = (!empty($this->arrayMessageError) ? count($this->arrayMessageError) : 0);
        if ($this->countError > 0) {
            foreach (range(1, $this->countError) as $index) {
                array_push($this->customError, $this->errorResponse($this->arrayMessageError[$index - 1]));
            }
            return $this->customError;
        }
        return [$this->errorResponse($this->message)];
    }

    /**
     * Create DTO error response
     * @param $messageError
     * @return ResponseError
     */
    public function errorResponse($message): ResponseError
    {
        $errorResponse = new ResponseError();
        $errorResponse->setMessage($message);
        $errorResponse->setInternalMessage($this->internalMessage);
        $errorResponse->setInternalCode($this->internalCode);
        return $errorResponse;
    }

    /**
     * @return array
     */
    public function getCustomError(): array
    {
        return $this->createCustomError();
    }

    /**
     * @return string|null
     */
    public function getInternalMessage(): ?string
    {
        return $this->internalMessage;
    }

    /**
     * @return int|null
     */
    public function getInternalCode(): ?int
    {
        return $this->internalCode;
    }

    /**
     * @return array
     */
    public function getArrayMessageError(): array
    {
        return $this->arrayMessageError;
    }
}
