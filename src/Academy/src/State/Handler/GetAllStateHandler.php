<?php

declare(strict_types=1);

namespace Academy\State\Handler;

use Exception;
use App\Util\Enum\StatusHttp;
use App\Service\Response\ApiResponse;
use Psr\Http\Message\ResponseInterface;
use Academy\State\Service\GetStateService;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Academy\State\Exception\StateDatabaseException;

class GetAllStateHandler implements RequestHandlerInterface
{
    /**
     * @var GetStateService
     */
    private $getStateService;

    public function __construct(
        GetStateService $getStateService
    ) {
        $this->getStateService = $getStateService;
    }

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        try {
            $getState = $this->getStateService->getAllStates();

            return new ApiResponse(
                $getState,
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
