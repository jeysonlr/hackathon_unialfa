<?php

declare(strict_types=1);

namespace Academy\User\Middleware;

use Academy\User\Exception\UserMiddlewareException;
use Academy\User\Service\GetUserService;
use Academy\User\Service\GetUserServiceInterface;
use App\Util\Enum\StatusHttp;
use Throwable;
use Academy\User\DTO\User;
use App\Service\Response\ApiResponse;
use App\Util\Serialize\SerializeUtil;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use App\Util\Validation\ValidationService;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use App\Exception\BaseException\BaseException;

class PostUserMiddleware implements MiddlewareInterface
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
        try {/** @var User $user */
            $user = $this->jms->deserialize(
                $request->getBody()->getContents(),
                User::class,
                'json'
            );

            $this->validationService->validateEntity($user);
            $user->setCpf(str_replace(['.', '-'], '', $user->getCpf()));

            if ($this->getUserService->getUserByCpf(str_replace(['.', '-'], '', $user->getCpf()))) {
                throw new UserMiddlewareException(
                    StatusHttp::CONFLICT,
                    "CPF já cadastrado"
                );
            }
        } catch (BaseException $e) {
            return new ApiResponse($e->getCustomError(), $e->getCode());
        } catch (Throwable $e) {
            return new ApiResponse($e->getMessage(), $e->getCode());
        }
        return $handler->handle($request->withAttribute("body", $user));
    }
}
