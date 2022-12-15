<?php

declare(strict_types=1);

namespace Academy\Authentication\DTO;

use App\Entity\BaseEntityInterface;
use JMS\Serializer\Annotation\Type;
use Symfony\Component\Validator\Constraints\NotNull;
use Symfony\Component\Validator\Constraints\NotBlank;

class AuthenticationUser implements BaseEntityInterface
{
    /**
     * @var string
     * @Type("string")
     * @NotNull(message="O campo login deve ser preenchido!")
     * @NotBlank(message="O campo login deve ser preenchido!")
     */
    private $login;

    /**
     * @var string
     * @Type("string")
     * @NotBlank(message="O campo password deve ser preenchido!")
     */
    private $password;

    /**
     * @return string|null
     */
    public function getLogin(): ?string
    {
        return $this->login;
    }

    /**
     * @param string $login
     */
    public function setLogin(string $login): void
    {
        $this->login = $login;
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
}
