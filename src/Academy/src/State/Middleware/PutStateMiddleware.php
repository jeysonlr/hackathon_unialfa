<?php

declare(strict_types=1);

namespace Academy\State\Middleware;

use Exception;
use App\Util\Enum\StatusHttp;
use App\Util\Enum\ErrorMessage;
use Academy\State\Entity\State;
use App\Service\Response\ApiResponse;
use App\Util\Serialize\SerializeUtil;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use App\Util\Validation\ValidationService;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Academy\State\Service\GetStateService;
use Academy\State\Exception\StateDatabaseException;
use App\Util\Validation\CheckConstraints\Exception\BaseEntityException;
use App\Util\Validation\CheckConstraints\Exception\BaseEntityViolationsException;

class PutStateMiddleware implements MiddlewareInterface
{
    /**
     * @var SerializeUtil
     */
    private $serialize;

    /**
     * @var ValidationService
     */
    private $validationService;

    /**
     * @var GetStateService
     */
    private $getStateService;

    public function __construct(
        SerializeUtil $serialize,
        ValidationService $validationService,
        GetStateService $getStateService
    ) {
        $this->serialize = $serialize;
        $this->validationService = $validationService;
        $this->getStateService = $getStateService;
    }

    /**
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            $state = $this->serialize->deserialize(
                $request->getBody()->getContents(),
                State::class,
                'json'
            );

            $stateId = intval($request->getAttribute('estadoId'));
            $this->validationService->validateEntity($state, ['update']);

            if (!$this->getStateService->getStateById($stateId)) {
                throw new StateDatabaseException(
                    StatusHttp::NOT_FOUND,
                    sprintf(
                        ErrorMessage::ERROR_REGISTER_NOT_FOUND,
                        $stateId
                    )
                );
            }

            $state->setEstadoid($stateId);
        } catch (BaseEntityException $e) {
            return new ApiResponse($e->getCustomError(), $e->getCode(), ApiResponse::ERROR);
        } catch (BaseEntityViolationsException $e) {
            return new ApiResponse($e->getCustomError(), $e->getCode(), ApiResponse::ERROR);
        } catch (StateDatabaseException $e) {
            return new ApiResponse($e->getCustomError(), $e->getCode(), ApiResponse::ERROR);
        } catch (Exception $e) {
            return new ApiResponse($e->getMessage(), $e->getCode(), ApiResponse::ERROR);
        }
        return $handler->handle($request->withAttribute('putState', $state));
    }
}
