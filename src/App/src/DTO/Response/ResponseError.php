<?php

declare(strict_types=1);

namespace App\DTO\Response;

use JMS\Serializer\Annotation\Type;

class ResponseError
{
    /**
     * @var null|string
     * @Type("string")
     */
    private $message;

    /**
     * @var null|string
     * @Type("string")
     */
    private $internalmessage;

    /**
     * @var null|int
     * @Type("int")
     */
    private $internalcode;

    /**
     * @return mixed
     */
    public function getMessage()
    {
        return $this->message;
    }

    /**
     * @param mixed $messageerror
     */
    public function setMessage($message): void
    {
        $this->message = $message;
    }

    /**
     * @return string|null
     */
    public function getInternalMessage(): ?string
    {
        return $this->internalmessage;
    }

    /**
     * @param string|null $internalmessageerror
     */
    public function setInternalMessage(?string $internalmessage): void
    {
        $this->internalmessage = $internalmessage;
    }

    /**
     * @return int|null
     */
    public function getInternalCode(): ?int
    {
        return $this->internalcode;
    }

    /**
     * @param int|null $internalcodeerror
     */
    public function setInternalCode(?int $internalcode): void
    {
        $this->internalcode = $internalcode;
    }
}
