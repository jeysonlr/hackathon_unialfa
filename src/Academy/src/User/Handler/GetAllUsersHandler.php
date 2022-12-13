<?php

declare(strict_types=1);

namespace Academy\User\Handler;

use Throwable;
use App\Util\Enum\StatusHttp;
use App\Service\Response\ApiResponse;
use Psr\Http\Message\ResponseInterface;
use Academy\User\Service\GetUserService;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface;
use App\Exception\BaseException\BaseException;
use Academy\User\Service\GetUserServiceInterface;
use Academy\User\Exception\UserDatabaseException;

class GetAllUsersHandler implements RequestHandlerInterface
{
    /**
     * @var GetUserServiceInterface
     */
    private $getUserService;

    public function __construct(GetUserService $getUserService)
    {
        $this->getUserService = $getUserService;
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        try {
            $users = $this->getUserService->getAllUsers();

            return new ApiResponse(
                $users,
                StatusHttp::OK,
                ApiResponse::SUCCESS
            );
        } catch (UserDatabaseException $e) {
            return new ApiResponse($e->getMessage(), $e->getCode(), ApiResponse::ERROR, null, $e);
        } catch (BaseException $e) {
            return new ApiResponse($e->getCustomError(), $e->getCode(), ApiResponse::ERROR, null, $e);
        } catch (Throwable $e) {
            return new ApiResponse($e->getMessage(), $e->getCode(), ApiResponse::ERROR, null, $e);
        }
    }
}
