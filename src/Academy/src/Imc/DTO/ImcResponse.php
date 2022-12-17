<?php

namespace Academy\Imc\DTO;

use DateTime;
use JMS\Serializer\Annotation\Type;

final class ImcResponse
{
    /**
     * @var integer
     * @Type("integer")
     */
    private $id;

    /**
     * @var integer
     * @Type("integer")
     */
    private $clientId;

    /**
     * @var integer
     * @Type("integer")
     */
    private $profissionalId;

    /**
     * @var float
     * @Type("float")
     */
    private $weight;

    /**
     * @var float
     * @Type("float")
     */
    private $height;

    /**
     * @var float
     * @Type("float")
     */
    private $result;

    /**
     * @var DateTime
     * @Type("DateTime")
     */
    private $createdAt;

    public function __construct(
        int $id,
        int $clientId,
        int $profissionalId,
        float $weight,
        float $height,
        float $result,
        DateTime $createdAt
    )
    {
        $this->id = $id;
        $this->clientId = $clientId;
        $this->profissionalId = $profissionalId;
        $this->weight = $weight;
        $this->height = $height;
        $this->result = $result;
        $this->createdAt =  $createdAt;
    }

    public static function build(
        int $id,
        int $clientId,
        int $profissionalId,
        float $weight,
        float $height,
        float $result,
        DateTime $createdAt
    ): ImcResponse {
        return new ImcResponse($id, $clientId, $profissionalId, $weight,  $height, $result, $createdAt);
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return int
     */
    public function getClientId(): int
    {
        return $this->clientId;
    }

    /**
     * @return int
     */
    public function getProfissionalId(): int
    {
        return $this->profissionalId;
    }

    /**
     * @return float
     */
    public function getWeight(): float
    {
        return $this->weight;
    }

    /**
     * @return float
     */
    public function getHeight(): float
    {
        return $this->height;
    }

    /**
     * @return float
     */
    public function getResult(): float
    {
        return $this->result;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'clientId' => $this->clientId,
            'profissionalId' => $this->profissionalId,
            'weight' => $this->weight,
            'height' => $this->height,
            'result' => $this->result,
            'createdAt' => $this->createdAt->format('d-m-Y h:m:s')
        ];
    }
}