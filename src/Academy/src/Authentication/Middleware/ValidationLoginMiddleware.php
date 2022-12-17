<?php

declare(strict_types=1);

namespace Academy\Authentication\Middleware;

use Throwable;
use App\Util\Enum\StatusHttp;
use App\Service\Response\ApiResponse;
use App\Util\Serialize\SerializeUtil;
use Psr\Http\Message\ResponseInterface;
use Academy\User\Service\GetUserService;
use Psr\Http\Server\MiddlewareInterface;
use App\Util\Validation\ValidationService;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use App\Exception\BaseException\BaseException;
use Academy\Authentication\DTO\AuthenticationUser;
use Academy\User\Service\GetUserServiceInterface;
use Academy\Authentication\Exception\UserNotFoundException;
use Academy\Authentication\Exception\UserPasswordDoesntMatchException;
use App\Util\Validation\CheckConstraints\Exception\BaseEntityViolationsException;

class ValidationLoginMiddleware implements MiddlewareInterface
{
    /**
     * @var SerializeUtil
     */
    private $jms;

    /**
     * @var ValidationService
     */
    private $validationService;

    /**
     * @var GetUserServiceInterface
     */
    private $getUserService;

    public function __construct(
        SerializeUtil $jms,
        ValidationService $validationService,
        GetUserService $getUserService
    ) {
        $this->jms = $jms;
        $this->validationService = $validationService;
        $this->getUserService = $getUserService;
    }

    /**
     * @param ServerRequestInterface  $request
     * @param RequestHandlerInterface $handler
     *
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            /** @var AuthenticationUser $user */
            $user = $this->jms->deserialize(
                $request->getBody()->getContents(),
                AuthenticationUser::class,
                "json"
            );

            $this->validationService->validateEntity($user);

            $userSearch = $this->getUserService->getUserPasswordByCpf($user->getLogin());

            if (!$userSearch) {
                throw new UserNotFoundException(
                    StatusHttp::BAD_REQUEST,
                    'Usuário ou senha incorretos!'
                );
            }

            $this->validatePassword($user->getPassword(), $userSearch->getPassword());
        } catch (BaseException $e) {
            return new ApiResponse($e->getCustomError(), $e->getCode());
        } catch (BaseEntityViolationsException $e) {
            return new ApiResponse($e->getCustomError(), $e->getCode());
        } catch (Throwable $e) {
            return new ApiResponse($e->getMessage(), $e->getCode());
        }

        return $handler->handle($request->withAttribute("user", $userSearch));
    }

    /**
     * @param string $password
     * @param string $hashedPassword
     *
     * @return bool|null
     * @throws UserPasswordDoesntMatchException
     */
    private function validatePassword(string $password, string $hashedPassword): ?bool
    {
        if (!password_verify($password, $hashedPassword)) {
            throw new UserPasswordDoesntMatchException(
                StatusHttp::UNAUTHORIZED,
                "O login ou senha estão incorretos!",
                "O login ou senha estão incorretos!"
            );
        }
        return true;
    }
}
