<?php

declare(strict_types=1);

namespace Academy\State\Middleware;

use Exception;
use App\Util\Enum\StatusHttp;
use App\Util\Enum\ErrorMessage;
use Academy\State\Entity\State;
use App\Util\Serialize\SerializeUtil;
use App\Service\Response\ApiResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use App\Util\Validation\ValidationService;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Academy\State\Service\GetStateService;
use Academy\State\Exception\StateDatabaseException;
use App\Util\Validation\CheckConstraints\Exception\BaseEntityException;
use App\Util\Validation\CheckConstraints\Exception\BaseEntityViolationsException;

class PostStateMiddleware implements MiddlewareInterface
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

            $this->validationService->validateEntity($state, ['insert']);

            $databaseState = $this->getStateService->getStateByName($state->getNome());

            if ($databaseState & $databaseState['nome'] === $state->getNome()) {
                throw new StateDatabaseException(
                    StatusHttp::CONFLICT,
                    ErrorMessage::ERROR_STATE_DUPLICATED
                );
            }

            $state->setNome(strtoupper($state->getNome()));
            $state->setAbreviacao(strtoupper($state->getAbreviacao()));
        } catch (BaseEntityException $e) {
            return new ApiResponse($e->getCustomError(), $e->getCode(), ApiResponse::ERROR);
        } catch (BaseEntityViolationsException $e) {
            return new ApiResponse($e->getCustomError(), $e->getCode(), ApiResponse::ERROR);
        } catch (StateDatabaseException $e) {
            return new ApiResponse($e->getCustomError(), $e->getCode(), ApiResponse::ERROR);
        } catch (Exception $e) {
            return new ApiResponse($e->getMessage(), $e->getCode(), ApiResponse::ERROR);
        }

        return $handler->handle($request->withAttribute('postState', $state));
    }
}
