<?php

declare(strict_types=1);

namespace Academy\State\Handler;

use Exception;
use App\Util\Enum\StatusHttp;
use App\Service\Response\ApiResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Academy\State\Service\PostStateService;
use Academy\State\Exception\StateDatabaseException;
use Psr\Http\Server\RequestHandlerInterface;

class PostStateHandler implements RequestHandlerInterface
{
    /**
     * @var PostStateService
     */
    private $postStateService;

    public function __construct(
        PostStateService $postStateService
    ) {
        $this->postStateService = $postStateService;
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        try {
            $response = $this->postStateService->insertState(
                $request->getAttribute('postState')
            );

            return new ApiResponse(
                $response,
                StatusHttp::OK,
                ApiResponse::SUCCESS
            );
        } catch (StateDatabaseException $e) {
            return new ApiResponse($e->getCustomError(), $e->getCode(), ApiResponse::ERROR);
        } catch (Exception $e) {
            return new ApiResponse($e->getMessage(), $e->getCode(), ApiResponse::ERROR);
        }
    }
}
