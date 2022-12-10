<?php

declare(strict_types=1);

namespace Academy\City\Dto;

use DateTime;
use JMS\Serializer\Annotation\Type;

class CityDto
{
    /**
     * @var int
     * @Type("int")
     */
    private $cidadeid;

    /**
     * @var string
     * @Type("string")
     */
    private $nome;

    /**
     * @var int
     * @Type("int")
     */
    private $estadoid;

    /**
     * @var @var string
     * @Type("string")
     */
    private $estadonome;

    /**
     * @var Datetime
     * @Type("DateTime<'d/m/Y H:i:s'>")
     */
    private $datacriacao;

    /**
     * @var Datetime
     * @Type("DateTime<'d/m/Y H:i:s'>")
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

    /**
     * @return mixed
     */
    public function getEstadonome()
    {
        return $this->estadonome;
    }

    /**
     * @param mixed $estadonome
     */
    public function setEstadonome($estadonome): void
    {
        $this->estadonome = $estadonome;
    }
}
