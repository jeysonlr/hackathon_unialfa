<?php

declare(strict_types=1);

namespace Academy\City\Handler;

use Exception;
use App\Util\Enum\StatusHttp;
use App\Service\Response\ApiResponse;
use Psr\Http\Message\ResponseInterface;
use Academy\City\Service\PutCityService;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Academy\City\Exception\CityDatabaseException;

class PutCityHandler implements RequestHandlerInterface
{
    /**
     * @var PutCityService
     */
    private $putCityService;

    public function __construct(
        PutCityService $putCityService
    ) {
        $this->putCityService = $putCityService;
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        try {
            $response = $this->putCityService->updateCity(
                $request->getAttribute('putCity')
            );

            return new ApiResponse(
                $response,
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
