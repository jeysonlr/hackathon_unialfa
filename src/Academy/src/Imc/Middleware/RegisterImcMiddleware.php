<?php

namespace Academy\Imc\Middleware;

use Academy\Imc\Entity\Imc;
use Academy\Imc\Service\ImcServiceInterface;
use App\Exception\BaseException\BaseException;
use App\Service\Response\ApiResponse;
use App\Util\Enum\StatusHttp;
use App\Util\Serialize\SerializeUtil;
use App\Util\Validation\CheckConstraints\Exception\BaseEntityViolationsException;
use App\Util\Validation\ValidationService;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Throwable;

final class RegisterImcMiddleware implements MiddlewareInterface
{
    /**
     * @var ValidationService
     */
    private $validationService;

    /**
     * @var SerializeUtil
     */
    private $jms;

    /**
     * @var ImcServiceInterface
     */
    private $imcService;

    public function __construct(SerializeUtil $jms, ValidationService $validationService) {
        $this->jms = $jms;
        $this->validationService = $validationService;
    }

    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            /** @var Imc $imc */
            $imc = $this->jms->deserialize($request->getBody()->getContents(), Imc::class, 'json');

            $this->validationService->validateEntity($imc);
        } catch (BaseEntityViolationsException|BaseException $e) {
            return new ApiResponse($e->getCustomError(), $e->getCode());
        } catch (Throwable $e) {
            return new ApiResponse($e->getMessage(), $e->getCode());
        }

        return $handler->handle($request->withAttribute("body", $imc));
    }
}