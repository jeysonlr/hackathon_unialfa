<?php

declare(strict_types=1);

namespace Academy\User\Handler;

use App\Util\Enum\StatusHttp;
use App\Service\Response\ApiResponse;
use Psr\Http\Message\ResponseInterface;
use Academy\User\Service\GetUserService;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Academy\User\Service\GetUserServiceInterface;
use Academy\User\Exception\UserDatabaseException;

class GetUserByIdHandler implements RequestHandlerInterface
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
     *
     * @return ResponseInterface
     * @throws UserDatabaseException
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        die('teste');
        $id = intval($request->getAttribute('id'));

        $user = $this->getUserService->getUserById($id);
        return new ApiResponse(
            $user,
            StatusHttp::OK,
            ApiResponse::SUCCESS
        );
    }
}
