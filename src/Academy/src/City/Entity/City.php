<?php

declare(strict_types=1);

namespace Academy\City\Entity;

use App\Entity\BaseEntityInterface;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Type;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 *public.cidades
 *
 * @ORM\Table(schema="public", name="cidades")
 * @ORM\Entity(repositoryClass="Academy\City\Repository\CityRepository")
 */
class City implements BaseEntityInterface
{
    /** 
     * @var int
     * @Type("int")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\SequenceGenerator(sequenceName="public.cidades_id_seq", allocationSize=1, initialValue=1)
     * @ORM\Column(name="cidadeid", type="integer", nullable=false)
     */
    private $cidadeid;

    /**
     * @var string
     * @Type("string")
     * @ORM\Column(name="nome", type="text", nullable=false)
     * @NotBlank(groups={"insert", "update"}, message="O campo nome é obrigatório!")
     */
    private $nome;

    /**
     * @var int
     * @Type("int")
     * @ORM\Column(name="estadoid", type="integer", nullable=false)
     * @NotBlank(groups={"insert", "update"}, message="O id do estado é obrigatório!")
     */
    private $estadoid;

    /**
     * @var Datetime
     * @Type("DateTime<'d/m/Y H:i:s'>")
     * @ORM\Column(name="datacriacao", type="datetime")
     */
    private $datacriacao;

    /**
     * @var Datetime
     * @Type("DateTime<'d/m/Y H:i:s'>")
     * @ORM\Column(name="dataalteracao", type="datetime")
     */
    private $dataalteracao;

    /**
     * @return int
     */
    public function getCidadeid(): int
    {
        return $this->cidadeid;
    }

    /**
     * @param int $cidadeid
     */
    public function setCidadeid(int $cidadeid): void
    {
        $this->cidadeid = $cidadeid;
    }

    /**
     * @return string
     */
    public function getNome(): string
    {
        return $this->nome;
    }

    /**
     * @param string $nome
     */
    public function setNome(string $nome): void
    {
        $this->nome = $nome;
    }

    /**
     * @return int
     */
    public function getEstadoid(): int
    {
        return $this->estadoid;
    }

    /**
     * @param int $estadoid
     */
    public function setEstadoid(int $estadoid): void
    {
        $this->estadoid = $estadoid;
    }

    /**
     * @return DateTime|null
     */
    public function getDatacriacao(): ?DateTime
    {
        return $this->datacriacao;
    }

    /**
     * @param DateTime|null $datacriacao
     */
    public function setDatacriacao(?DateTime $datacriacao): void
    {
        $this->datacriacao = $datacriacao;
    }

    /**
     * @return DateTime|null
     */
    public function getDataalteracao(): ?DateTime
    {
        return $this->dataalteracao;
    }

    /**
     * @param DateTime|null $dataalteracao
     */
    public function setDataalteracao(?DateTime $dataalteracao): void
    {
        $this->dataalteracao = $dataalteracao;
    }
}
