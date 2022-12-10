<?php

declare(strict_types=1);

namespace Academy\City\Handler;

use Exception;
use App\Util\Enum\StatusHttp;
use App\Service\Response\ApiResponse;
use Psr\Http\Message\ResponseInterface;
use Academy\City\Service\GetCityService;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Academy\City\Exception\CityDatabaseException;

class GetAllCityHandler implements RequestHandlerInterface
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

    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        try {
            $getCity = $this->getCityService->getAllCitys();

            return new ApiResponse(
                $getCity,
                StatusHttp::OK,
                ApiResponse::SUCCESS
            );
        } catch (CityDatabaseException $e) {
            return new ApiResponse($e->getCustomError(), $e->getCode(), ApiResponse::ERROR);
        } catch (Exception $e) {
            return new ApiResponse($e->getMessage(), $e->getCode(), ApiResponse::ERROR);
        }
    }
}
