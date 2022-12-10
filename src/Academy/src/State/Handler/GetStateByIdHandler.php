<?php

declare(strict_types=1);

namespace Academy\State\Handler;

use Exception;
use App\Util\Enum\StatusHttp;
use App\Util\Enum\ErrorMessage;
use App\Service\Response\ApiResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Academy\State\Service\GetStateService;
use Academy\State\Exception\StateDatabaseException;

class GetStateByIdHandler implements RequestHandlerInterface
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

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        try {
            $getState = $this->getStateService->getStateAndCitysById(
                intval($request->getAttribute("estadoId"))
            );

            if (!$getState) {
                throw new StateDatabaseException(
                    StatusHttp::NOT_FOUND,
                    sprintf(
                        ErrorMessage::ERROR_REGISTER_NOT_FOUND,
                        intval($request->getAttribute("estadoId"))
                    )
                );
            }

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
