<?php

declare(strict_types=1);

namespace Academy\City\Handler;

use Exception;
use App\Util\Enum\StatusHttp;
use App\Util\Enum\ErrorMessage;
use App\Service\Response\ApiResponse;
use Psr\Http\Message\ResponseInterface;
use Academy\City\Service\GetCityService;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Academy\City\Exception\CityIdException;
use Academy\City\Exception\CityDatabaseException;

class GetCityByIdHandler implements RequestHandlerInterface
{
    /**
     * @var GetCityService
     */
    private $getCityService;

    public function __construct(
        GetCityService $getCityService
    ) {
        $this->getCityService = $getCityService;
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        try {
            $cityId = intval($request->getAttribute("cidadeId"));

            $getCity = $this->getCityService->getCityById(
                $cityId
            );

            if (!$getCity) {
                throw new CityIdException(
                    StatusHttp::NOT_FOUND,
                    sprintf(
                        ErrorMessage::ERROR_REGISTER_NOT_FOUND,
                        $cityId
                    )
                );
            }

            return new ApiResponse(
                $getCity,
                StatusHttp::OK,
                ApiResponse::SUCCESS
            );
        } catch (CityDatabaseException $e) {
            return new ApiResponse($e->getCustomError(), $e->getCode(), ApiResponse::ERROR);
        } catch (CityIdException $e) {
            return new ApiResponse($e->getCustomError(), $e->getCode(), ApiResponse::ERROR);
        } catch (Exception $e) {
            return new ApiResponse($e->getMessage(), $e->getCode(), ApiResponse::ERROR);
        }
    }
}
