<?php

namespace Academy\Imc\Middleware;

use Academy\Authentication\Exception\UserNotFoundException;
use Academy\Imc\Entity\Imc;
use Academy\Imc\Service\ImcServiceInterface;
use Academy\User\Exception\UserDatabaseException;
use Academy\User\Exception\UsersNotFoundException;
use Academy\User\Service\GetUserServiceInterface;
use App\Exception\BaseException\BaseException;
use App\Service\Response\ApiResponse;
use App\Util\Enum\StatusHttp;
use App\Util\Serialize\SerializeUtil;
use App\Util\Validation\CheckConstraints\Exception\BaseEntityViolationsException;
use App\Util\Validation\ValidationService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Throwable;

final class RegisterImcMiddleware implements MiddlewareInterface
{
    /**
     * @var ValidationService
     */
    private $validationService;

    /**
     * @var SerializeUtil
     */
    private $jms;

    /**
     * @var GetUserServiceInterface
     */
    private $getUserService;

    public function __construct(
        SerializeUtil $jms,
        ValidationService $validationService,
        GetUserServiceInterface $getUserService
    ) {
        $this->jms = $jms;
        $this->validationService = $validationService;
        $this->getUserService = $getUserService;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            /** @var Imc $imc */
            $imc = $this->jms->deserialize($request->getBody()->getContents(), Imc::class, 'json');
            $imc->fillDate();

            $this->checkUserExists($imc->getClientId());
            $this->checkUserExists($imc->getProfissionalId());

            $this->validationService->validateEntity($imc);
        } catch (BaseEntityViolationsException|BaseException $e) {
            return new ApiResponse($e->getCustomError(), $e->getCode());
        } catch (Throwable $e) {
            return new ApiResponse($e->getMessage(), $e->getCode());
        }

        return $handler->handle($request->withAttribute("body", $imc));
    }

    /**
     * @throws UserDatabaseException|UsersNotFoundException
     */
    private function checkUserExists(int $userId): void
    {
        if(is_null($this->getUserService->getUserById($userId))) {
            throw new UsersNotFoundException(
                StatusHttp::NOT_FOUND,
                sprintf('Usuário informado inexistente: %s', $userId)
            );
        }
    }
}