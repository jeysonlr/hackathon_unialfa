<?php

declare(strict_types=1);

namespace Academy\Authentication\Handler;

use Throwable;
use App\Util\Enum\StatusHttp;
use App\Service\Response\ApiResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use App\Exception\BaseException\BaseException;
use Academy\Authentication\Exception\CreateTokenException;
use Academy\Authentication\Service\AuthenticationTokenService;
use Academy\Authentication\Exception\RequiredValueRequestException;

class AuthenticationTokenHandler implements RequestHandlerInterface
{
    /**
     * @var AuthenticationTokenService
     */
    private $authenticationTokenService;

    public function __construct(AuthenticationTokenService $authenticationTokenService)
    {
        $this->authenticationTokenService = $authenticationTokenService;
    }

    /**
     * @param ServerRequestInterface $request
     *
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        try {
            $result = $this->authenticationTokenService->createUserToken(
                $request->getAttribute("user")
            );

            return new ApiResponse(
                $result,
                StatusHttp::OK
            );
        } catch (CreateTokenException $e) {
            return new ApiResponse($e->getMessage(), $e->getCode(), ApiResponse::ERROR, null, $e);
        } catch (RequiredValueRequestException $e) {
            return new ApiResponse($e->getMessage(), $e->getCode(), ApiResponse::ERROR, null, $e);
        } catch (BaseException $e) {
            return new ApiResponse($e->getCustomError(), $e->getCode(), ApiResponse::ERROR, null, $e);
        } catch (Throwable $e) {
            return new ApiResponse($e->getMessage(), $e->getCode(), ApiResponse::ERROR, null, $e);
        }
    }
}
