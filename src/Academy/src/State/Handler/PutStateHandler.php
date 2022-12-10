<?php

declare(strict_types=1);

namespace Academy\State\Handler;

use Exception;
use App\Util\Enum\StatusHttp;
use App\Service\Response\ApiResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Academy\State\Service\PutStateService;
use Academy\State\Exception\StateDatabaseException;

class PutStateHandler implements RequestHandlerInterface
{
    /**
     * @var PutStateService
     */
    private $putStateService;

    public function __construct(
        PutStateService $putStateService
    ) {
        $this->putStateService = $putStateService;
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        try {
            $response = $this->putStateService->updateState(
                $request->getAttribute('putState')
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
