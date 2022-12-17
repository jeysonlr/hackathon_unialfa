<?php

declare(strict_types=1);

namespace Academy\Imc\Entity;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use App\Entity\BaseEntityInterface;
use JMS\Serializer\Annotation\Type;

/**
 * @ORM\Table(schema="public", name="imc")
 * @ORM\Entity(repositoryClass="Academy\Imc\Repository\ImcRepository")
 */
class Imc implements BaseEntityInterface
{
    /**
     * @var int
     * @ORM\Id
     * @Type("int")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(name="id", type="integer", name="id")
     */
    private $id;

    /**
     * @var integer
     * @Type("integer")
     * @ORM\Column(name="cliente_id", type="integer")
     */
    private $clientId;

    /**
     * @var integer
     * @Type("integer")
     * @ORM\Column(name="profissional_id", type="integer")
     */
    private $profissionalId;

    /**
     * @var float
     * @Type("float")
     * @ORM\Column(name="peso", type="float")
     */
    private $weight;

    /**
     * @var float
     * @Type("float")
     * @ORM\Column(name="altura", type="float")
     */
    private $height;

    /**
     * @var float
     * @Type("float")
     * @ORM\Column(name="resultado", type="float")
     */
    private $result;

    /**
     * @var DateTime
     * @Type("DateTime")
     * @ORM\Column(name="data_hora", type="datetime")
     */
    private $createdAt;

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

    public function fillDate()
    {
        $this->createdAt = new DateTime();
    }
}
