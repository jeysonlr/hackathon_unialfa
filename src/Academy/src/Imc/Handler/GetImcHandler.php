<?php

declare(strict_types=1);

namespace Academy\Imc\Handler;

use Academy\Imc\Exception\ImcDatabaseException;
use Academy\Imc\Service\ImcServiceInterface;
use Throwable;
use App\Util\Enum\StatusHttp;
use App\Service\Response\ApiResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Psr\Http\Message\ServerRequestInterface;
use App\Exception\BaseException\BaseException;

class GetImcHandler implements RequestHandlerInterface
{
    /**
     * @var ImcServiceInterface
     */
    private $imcService;

    public function __construct(ImcServiceInterface $imcService)
    {
        $this->imcService = $imcService;
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        try {
            $imcResults = $this->imcService->findAll();

            return new ApiResponse($imcResults, StatusHttp::OK, ApiResponse::SUCCESS);
        } catch (ImcDatabaseException $e) {
            return new ApiResponse($e->getMessage(), $e->getCode(), ApiResponse::ERROR, null, $e);
        } catch (BaseException $e) {
            return new ApiResponse($e->getCustomError(), $e->getCode(), ApiResponse::ERROR, null, $e);
        } catch (Throwable $e) {
            return new ApiResponse($e->getMessage(), $e->getCode(), ApiResponse::ERROR, null, $e);
        }
    }
}
