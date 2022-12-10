<?php

declare(strict_types=1);

namespace Academy\State\Entity;

use App\Entity\BaseEntityInterface;

use DateTime;
use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation\Type;
use Symfony\Component\Validator\Constraints\NotBlank;

/**
 *public.estados
 *
 * @ORM\Table(schema="public", name="estados")
 * @ORM\Entity(repositoryClass="Academy\State\Repository\StateRepository")
 */
class State implements BaseEntityInterface
{
    /** 
     * @var int
     * @Type("int")
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\SequenceGenerator(sequenceName="public.estados_id_seq", allocationSize=1, initialValue=1)
     * @ORM\Column(name="estadoid", type="integer", nullable=false)
     */
    private $estadoid;

    /**
     * @var string
     * @Type("string")
     * @ORM\Column(name="nome", type="text", nullable=false)
     * @NotBlank(groups={"insert", "update"}, message="O campo nome é obrigatório!")
     */
    private $nome;

    /**
     * @var string
     * @Type("string")
     * @ORM\Column(name="abreviacao", type="text", nullable=false)
     * @NotBlank(groups={"insert", "update"}, message="O campo abreviacao do estado é obrigatório!")
     */
    private $abreviacao;

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
     * @return string
     */
    public function getAbreviacao(): string
    {
        return $this->abreviacao;
    }

    /**
     * @param string $abreviacao
     */
    public function setAbreviacao(string $abreviacao): void
    {
        $this->abreviacao = $abreviacao;
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
