<?php

declare(strict_types=1);

namespace Academy\City\Middleware;

use Exception;
use App\Util\Enum\StatusHttp;
use App\Util\Enum\ErrorMessage;
use Academy\City\Entity\City;
use App\Service\Response\ApiResponse;
use App\Util\Serialize\SerializeUtil;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use App\Util\Validation\ValidationService;
use Academy\City\Service\GetCityService;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Academy\City\Exception\CityIdException;
use Academy\City\Exception\CityDatabaseException;
use App\Util\Validation\CheckConstraints\Exception\BaseEntityException;
use App\Util\Validation\CheckConstraints\Exception\BaseEntityViolationsException;

class PutCityMiddleware implements MiddlewareInterface
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

    public function __construct(
        SerializeUtil $serialize,
        ValidationService $validationService,
        GetCityService $getCityService
    ) {
        $this->serialize = $serialize;
        $this->validationService = $validationService;
        $this->getCityService = $getCityService;
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

            $cityId = intval($request->getAttribute('cidadeId'));

            if (!$this->getCityService->getCityById($cityId)) {
                throw new CityIdException(
                    StatusHttp::NOT_FOUND,
                    sprintf(
                        ErrorMessage::ERROR_REGISTER_NOT_FOUND,
                        $cityId
                    )
                );
            }

            $this->validationService->validateEntity($city, ['update']);
            $city->setCidadeid($cityId);
            $city->setNome(strtoupper($city->getNome()));
        } catch (BaseEntityException $e) {
            return new ApiResponse($e->getCustomError(), $e->getCode(), ApiResponse::ERROR);
        } catch (BaseEntityViolationsException $e) {
            return new ApiResponse($e->getCustomError(), $e->getCode(), ApiResponse::ERROR);
        } catch (CityDatabaseException $e) {
            return new ApiResponse($e->getCustomError(), $e->getCode(), ApiResponse::ERROR);
        } catch (CityIdException $e) {
            return new ApiResponse($e->getCustomError(), $e->getCode(), ApiResponse::ERROR);
        } catch (Exception $e) {
            return new ApiResponse($e->getMessage(), $e->getCode(), ApiResponse::ERROR);
        }
        return $handler->handle($request->withAttribute('putCity', $city));
    }
}
