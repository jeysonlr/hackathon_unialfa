<?php

declare(strict_types=1);

namespace Academy\User\Handler;

use Throwable;
use App\Util\Enum\StatusHttp;
use App\Util\Enum\SuccessMessage;
use App\Service\Response\ApiResponse;
use Psr\Http\Message\ResponseInterface;
use Academy\User\Service\PostUserService;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use App\Exception\BaseException\BaseException;
use Academy\User\Exception\UserDatabaseException;
use Academy\User\Service\PostUserServiceInterface;

class PostUsersHandler implements RequestHandlerInterface
{
    /**
     * @var PostUserServiceInterface
     */
    private $postUserService;

    public function __construct(PostUserService $postUserService)
    {
        $this->postUserService = $postUserService;
    }

    /**
     * @param ServerRequestInterface $request
     *
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        try {
            $body = $request->getAttribute("body");

            $this->postUserService->postUser($body);

            return new ApiResponse(
                SuccessMessage::SAVED_RECORD,
                StatusHttp::CREATED,
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
