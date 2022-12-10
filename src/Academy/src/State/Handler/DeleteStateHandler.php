<?php

declare(strict_types=1);

namespace Academy\State\Handler;

use Exception;
use App\Util\Enum\StatusHttp;
use App\Util\Enum\SuccessMessage;
use App\Service\Response\ApiResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Academy\State\Exception\StateIdException;
use Academy\State\Service\DeleteStateService;
use Academy\State\Exception\StateDatabaseException;

class DeleteStateHandler implements RequestHandlerInterface
{
    /**
     * @var DeleteStateService
     */
    private $deleteStateService;

    public function __construct(
        DeleteStateService $deleteStateService
    ) {
        $this->deleteStateService = $deleteStateService;
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        try {
            $stateId = intval($request->getAttribute("estadoId"));

            $this->deleteStateService->deleteState($stateId);

            return new ApiResponse(
                sprintf(
                    SuccessMessage::DELETING_RECORD,
                    $stateId
                ),
                StatusHttp::OK,
                ApiResponse::SUCCESS
            );
        } catch (StateDatabaseException $e) {
            return new ApiResponse($e->getCustomError(), $e->getCode(), ApiResponse::ERROR);
        } catch (StateIdException $e) {
            return new ApiResponse($e->getCustomError(), $e->getCode(), ApiResponse::ERROR);
        } catch (Exception $e) {
            return new ApiResponse($e->getMessage(), $e->getCode(), ApiResponse::ERROR);
        }
    }
}
