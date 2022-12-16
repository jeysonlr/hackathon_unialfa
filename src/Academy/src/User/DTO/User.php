<?php

declare(strict_types=1);

namespace Academy\User\DTO;

use App\Entity\BaseEntityInterface;
use JMS\Serializer\Annotation\Type;
use Symfony\Component\Validator\Constraints\NotBlank;
use Symfony\Component\Validator\Constraints\Choice;

class User implements BaseEntityInterface
{
    /**
     * @var string
     * @Type("string")
     * @NotBlank(message="O campo name é obrigatório!")
     */
    private $name;

    /**
     * @var string
     * @Type("string")
     * @NotBlank(message="O campo cpf é obrigatório!")
     */
    private $cpf;

    /**
     * @var string
     * @Type("string")
     * @NotBlank(message="O campo password é obrigatório!")
     */
    private $password;

    /**
     * @var string
     * @Type("string")
     * @Choice(
     *     choices = { "admin", "ADMIN", "professional", "PROFESSIONAL", "client", "CLIENT" },
     *     message = "As alternativas para type são: 'admin', 'professional' ou 'client'!"
     * )
     * @NotBlank(message="O campo type é obrigatório!")
     */
    private $type;

    /**
     * @return string
     */
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): void
    {
        $this->name = $name;
    }

    /**
     * @return string
     */
    public function getCpf(): string
    {
        return $this->cpf;
    }

    /**
     * @param string $cpf
     */
    public function setCpf(string $cpf): void
    {
        $this->cpf = $cpf;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     */
    public function setPassword(string $password): void
    {
        $this->password = $password;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }
}
