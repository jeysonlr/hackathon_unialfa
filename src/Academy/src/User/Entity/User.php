<?php

declare(strict_types=1);

namespace Academy\User\Entity;

use Doctrine\ORM\Mapping as ORM;
use App\Entity\BaseEntityInterface;
use JMS\Serializer\Annotation\Type;

/**
 *public.usuario
 *
 * @ORM\Table(schema="public", name="usuarios")
 * @ORM\Entity(repositoryClass="Academy\User\Repository\UserRepository")
 */
class User implements BaseEntityInterface
{
    /**
     * @var int
     * @ORM\Id
     * @Type("int")
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\SequenceGenerator(sequenceName="public.user_id_seq", initialValue=1, allocationSize=1)
     * @ORM\Column(name="id", type="integer", name="id")
     */
    private $id;

    /**
     * @var string
     * @Type("string")
     * @ORM\Column(name="nome", type="string")
     */
    private $name;

    /**
     * @var string
     * @Type("string")
     * @ORM\Column(name="cpf", type="string")
     */
    private $cpf;

    /**
     * @var string
     * @Type("string")
     * @ORM\Column(name="senha", type="string")
     */
    private $password;

    /**
     * @var string
     * @Type("string")
     * @ORM\Column(name="tipo", type="string")
     */
    private $type;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @param int $id
     */
    public function setId(int $id): void
    {
        $this->id = $id;
    }

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

    public function remove()
    {
        $this->password = null;
    }
}
