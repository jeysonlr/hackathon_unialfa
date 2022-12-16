<?php

declare(strict_types=1);

namespace Academy\Authentication\Service;

use Exception;
use Firebase\JWT\JWT;
use Academy\User\Entity\User;
use App\Util\Enum\StatusHttp;
use Firebase\JWT\ExpiredException;
use Academy\Authentication\DTO\Token;
use Firebase\JWT\SignatureInvalidException;
use Academy\Authentication\Exception\CreateTokenException;
use Academy\Authentication\Exception\ExpiredTokenException;
use Academy\Authentication\Exception\InvalidTokenException;
use Academy\Authentication\Exception\RequiredValueRequestException;
use Academy\Authentication\Exception\CheckSignatureInvalidException;

class AuthenticationTokenService
{
    /**
     * @var JWT
     */
    private $jwt;

    /**
     * @var array
     */
    private $tokenData;

    /**
     * @var string
     */
    private $algorithm;

    /**
     * @var string
     */
    private $key;

    public function __construct(
        JWT $jwt,
        array $tokenData
    ) {
        $this->jwt = $jwt;
        $this->tokenData = $tokenData;
        $this->algorithm = $this->tokenData["algorithm"];
        $this->key = $this->tokenData["key"];
    }

    /**
     * @param User|null $user
     *
     * @return Token
     * @throws CreateTokenException
     * @throws RequiredValueRequestException
     */
    public function createUserToken(?User $user): Token
    {
        if (empty($user)) {
            throw new RequiredValueRequestException(
                StatusHttp::BAD_REQUEST,
                "Os dados do usuário estão inválidos!",
                "Os dados do usuário estão inválidos para gerar token!"
            );
        }

        $createdAt = time();
        $expirationTime = $createdAt + $this->tokenData["expiration"];

        $payload = [
            "iat" => $createdAt,
            "iss" => $this->tokenData["serverName"],
            "nbf" => $createdAt,
            "exp" => $expirationTime,
            "data" => [
                "user_id" => $user->getId(),
                "type" => $user->getType()	
            ]
        ];

        $payload = $this->encode($payload);
        $token = new Token();
        $token->setToken($payload);

        return $token;
    }

    /**
     * @param array $payload
     * @return string
     * @throws CreateTokenException
     */
    private function encode(array $payload): string
    {
        try {
            return $this->jwt->encode($payload, base64_decode($this->key), $this->algorithm);
        } catch (Exception $e) {
            throw new CreateTokenException(
                StatusHttp::INTERNAL_SERVER_ERROR,
                "Ocorreu um erro ao gerar o token de acesso!",
                $e->getMessage()
            );
        }
    }

   /**
    * @param string $token
    * @return object|null
    * @throws CheckSignatureInvalidException
    * @throws ExpiredTokenException
    * @throws InvalidTokenException
    */
   public function decode(string $token): ?object
   {
       try {
           return $this->jwt->decode($token, base64_decode($this->key), [$this->algorithm]);
       } catch (ExpiredException $e) {
           throw new ExpiredTokenException(
               StatusHttp::UNAUTHORIZED,
               'O token informado está expirado'
           );
       } catch (SignatureInvalidException $e){
           throw new CheckSignatureInvalidException(
               StatusHttp::UNAUTHORIZED,
               'A chave de assinatura está inválida'
           );
       } catch (Exception $e) {
           throw new InvalidTokenException(
               StatusHttp::UNAUTHORIZED,
               'O token informado está inválidok'
           );
       }
   }
}
