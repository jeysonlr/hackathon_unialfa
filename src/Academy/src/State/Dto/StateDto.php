<?php

declare(strict_types=1);

namespace Academy\State\Dto;

use DateTime;
use JMS\Serializer\Annotation\Type;

class StateDto
{
    /**
     * @var int
     * @Type("int")
     */
    private $estadoid;

    /**
     * @var string
     * @Type("string")
     */
    private $nome;

    /**
     * @var string
     * @Type("string")
     */
    private $abreviacao;

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
     * @var array
     * @Type("array")
     */
    protected $cidades;

    /**
     * @return array|null
     */
    public function getCidades(): ?array
    {
        return $this->cidades;
    }

    /**
     * @param array|null $cidades
     */
    public function setCidades(?array $cidades): void
    {
        $this->cidades = $cidades;
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
