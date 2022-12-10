<?php

declare (strict_types=1);

namespace App\DTO\Response;

use JMS\Serializer\Annotation\Type;

class ResponseData
{
    /**
     * @var int
     * @Type("int")
     */
    private $statuscode;

    /**
     * @var mixed
     */
    private $data;

    /**
     * @var mixed
     */
    private $error;

    /**
     * @return int
     */
    public function getStatusCode(): int
    {
        return $this->statuscode;
    }

    /**
     * @param int $statuscode
     */
    public function setStatusCode(int $statuscode): void
    {
        $this->statuscode = $statuscode;
    }

    /**
     * @return mixed
     */
    public function getData()
    {
        return $this->data;
    }

    /**
     * @param mixed $data
     */
    public function setData($data): void
    {
        $this->data = $data;
    }

    /**
     * @return mixed
     */
    public function getError()
    {
        return $this->error;
    }

    /**
     * @param mixed $error
     */
    public function setError($error): void
    {
        $this->error = $error;
    }
}
