<?php

declare(strict_types=1);

namespace Academy\City\Middleware;

use Exception;
use App\Util\Enum\StatusHttp;
use App\Util\Enum\ErrorMessage;
use Academy\City\Entity\City;
use App\Util\Serialize\SerializeUtil;
use App\Service\Response\ApiResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use App\Util\Validation\ValidationService;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface;
use Academy\City\Service\GetCityService;
use Academy\State\Service\GetStateService;
use Academy\State\Exception\StateIdException;
use Academy\City\Exception\CityDatabaseException;
use App\Util\Validation\CheckConstraints\Exception\BaseEntityException;
use App\Util\Validation\CheckConstraints\Exception\BaseEntityViolationsException;

class PostCityMiddleware implements MiddlewareInterface
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
     * @var GetCityService
     */
    private $getCityService;

    /**
     * @var GetStateService
     */
    private $getStateService;

    public function __construct(
        SerializeUtil $serialize,
        ValidationService $validationService,
        GetCityService $getCityService,
        GetStateService $getStateService
    ) {
        $this->serialize = $serialize;
        $this->validationService = $validationService;
        $this->getCityService = $getCityService;
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
            $city = $this->serialize->deserialize(
                $request->getBody()->getContents(),
                City::class,
                'json'
            );

            $this->validationService->validateEntity($city, ['insert']);

            if (!$this->getStateService->getStateById($city->getEstadoid())) {
                throw new StateIdException(
                    StatusHttp::BAD_REQUEST,
                    sprintf(
                        ErrorMessage::ERROR_REGISTER_NOT_FOUND,
                        $city->getEstadoid()
                    )
                );
            }

            $databaseCity = $this->getCityService->getCityByName($city->getNome());

            if ($databaseCity & $databaseCity['estadoid'] === $city->getEstadoid()) {
                throw new CityDatabaseException(
                    StatusHttp::CONFLICT,
                    sprintf(
                        ErrorMessage::ERROR_CITY_DUPLICATED,
                        $city->getEstadoid()
                    )
                );
            }
            $city->setNome(strtoupper($city->getNome()));
        } catch (BaseEntityException $e) {
            return new ApiResponse($e->getCustomError(), $e->getCode(), ApiResponse::ERROR);
        } catch (BaseEntityViolationsException $e) {
            return new ApiResponse($e->getCustomError(), $e->getCode(), ApiResponse::ERROR);
        } catch (CityDatabaseException $e) {
            return new ApiResponse($e->getCustomError(), $e->getCode(), ApiResponse::ERROR);
        } catch (StateIdException $e) {
            return new ApiResponse($e->getCustomError(), $e->getCode(), ApiResponse::ERROR);
        } catch (Exception $e) {
            return new ApiResponse($e->getMessage(), $e->getCode(), ApiResponse::ERROR);
        }

        return $handler->handle($request->withAttribute('postCity', $city));
    }
}
