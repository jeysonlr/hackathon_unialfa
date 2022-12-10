<?php

declare(strict_types=1);

namespace Academy\User\Handler;

use Academy\User\Service\GetUserService;
use Academy\User\Service\GetUserServiceInterface;
use App\Service\Response\ApiResponse;
use App\Util\Enum\StatusHttp;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;

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

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        $users = $this->getUserService->getAllUsers();
        return new ApiResponse(
            $users,
            StatusHttp::OK,
            ApiResponse::SUCCESS
        );
    }
}
