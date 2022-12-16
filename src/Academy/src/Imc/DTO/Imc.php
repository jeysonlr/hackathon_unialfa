<?php

namespace Academy\Imc\DTO;

use App\Entity\BaseEntityInterface;
use DateTime;
use JMS\Serializer\Annotation\Type;
use Symfony\Component\Validator\Constraints\Positive;
use Symfony\Component\Validator\Constraints\GreaterThanOrEqual;
use Symfony\Component\Validator\Constraints\NotNull;


final class Imc
{
    /**
     * @var integer
     * @Type("integer")
     * @Positive (message="Identificador do cliente inválido!")
     */
    private $clientId;

    /**
     * @var integer
     * @Type("integer")
     * @Positive (message="Identificador do cliente inválido!")
     */
    private $profissionalId;

    /**
     * @var float
     * @Type("float")
     * @GreaterThanOrEqual(value=1, message="Peso inválido!")
     */
    private $weight;

    /**
     * @var float
     * @Type("float")
     * @NotNull(message="A altura deve ser informada!")
     */
    private $height;

    /**
     * @var DateTime
     * @Type("datetime")
     * @DateTime
     */
    private $createdAt;

    public function __construct(
        int $clientId,
        int $profissionalId,
        float $weight,
        float $height,
        DateTime $createdAt
    )
    {
        $this->clientId = $clientId;
        $this->profissionalId = $profissionalId;
        $this->weight = $weight;
        $this->height = $height;
        $this->createdAt =  $createdAt;
    }

    /**
     * @return int
     */
    public function getClientId(): int
    {
        return $this->clientId;
    }
}