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
     * @var DateTime
     * @Type("datetime")
     */
    private $createdAt;

    public function __construct(
        int $id,
        int $clientId,
        int $profissionalId,
        float $weight,
        float $height,
        DateTime $createdAt
    )
    {
        $this->id = $id;
        $this->clientId = $clientId;
        $this->profissionalId = $profissionalId;
        $this->weight = $weight;
        $this->height = $height;
        $this->createdAt =  $createdAt;
    }

    public static function build(
        int $id,
        int $clientId,
        int $profissionalId,
        float $weight,
        float $height,
        DateTime $createdAt
    ): ImcResponse {
        return new ImcResponse($id, $clientId, $profissionalId, $weight,  $height,  $createdAt);
    }

    public function toArray(): array
    {
        return [
            'id' => $this->id,
            'clientId' => $this->clientId,
            'profissionalId' => $this->profissionalId,
            'weight' => $this->weight,
            'height' => $this->height,

        ];
    }
}