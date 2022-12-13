<?php

declare(strict_types=1);

namespace Academy\User\Middleware;

use Throwable;
use Academy\User\DTO\User;
use App\Service\Response\ApiResponse;
use App\Util\Serialize\SerializeUtil;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use App\Util\Validation\ValidationService;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use App\Exception\BaseException\BaseException;

class PostUserMiddleware implements MiddlewareInterface
{
    /**
     * @var ValidationService
     */
    private $validationService;

    /**
     * @var SerializeUtil
     */
    private $jms;

    public function __construct(
        SerializeUtil $jms,
        ValidationService $validationService
    ) {
        $this->jms = $jms;
        $this->validationService = $validationService;
    }

    /**
     * @param ServerRequestInterface  $request
     * @param RequestHandlerInterface $handler
     *
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            $user = $this->jms->deserialize(
                $request->getBody()->getContents(),
                User::class,
                'json'
            );

            $this->validationService->validateEntity($user);
        } catch (BaseException $e) {
            return new ApiResponse($e->getCustomError(), $e->getCode());
        } catch (Throwable $e) {
            return new ApiResponse($e->getMessage(), $e->getCode());
        }
        return $handler->handle($request->withAttribute("body", $user));
    }
}
