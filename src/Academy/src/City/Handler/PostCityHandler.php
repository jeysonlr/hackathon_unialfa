<?php

declare(strict_types=1);

namespace Academy\City\Handler;

use Exception;
use App\Util\Enum\StatusHttp;
use App\Service\Response\ApiResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Academy\City\Service\PostCityService;
use Academy\City\Exception\CityDatabaseException;
use Psr\Http\Server\RequestHandlerInterface;

class PostCityHandler implements RequestHandlerInterface
{
    /**
     * @var PostCityService
     */
    private $postCityService;

    public function __construct(
        PostCityService $postCityService
    ) {
        $this->postCityService = $postCityService;
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        try {
            $response = $this->postCityService->insertCity(
                $request->getAttribute('postCity')
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
