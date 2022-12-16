<?php

namespace Academy\Imc\Handler;

use Academy\Imc\Exception\ImcDatabaseException;
use Academy\Imc\Service\ImcServiceInterface;
use App\Exception\BaseException\BaseException;
use App\Service\Response\ApiResponse;
use App\Util\Enum\StatusHttp;
use App\Util\Enum\SuccessMessage;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Throwable;

final class RegisterImcHandler implements RequestHandlerInterface
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
     *
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        try {
            $imc = $request->getAttribute("body");

            $this->imcService->register($imc);

            return new ApiResponse(
                SuccessMessage::SAVED_RECORD,
                StatusHttp::CREATED,
                ApiResponse::SUCCESS
            );
        } catch (ImcDatabaseException $e) {
            return new ApiResponse($e->getMessage(), $e->getCode(), ApiResponse::ERROR, null, $e);
        } catch (BaseException $e) {
            return new ApiResponse($e->getCustomError(), $e->getCode(), ApiResponse::ERROR, null, $e);
        } catch (Throwable $e) {
            return new ApiResponse($e->getMessage(), $e->getCode(), ApiResponse::ERROR, null, $e);
        }
    }
}