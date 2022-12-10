<?php

declare(strict_types=1);

namespace App\Middleware;

use Exception;
use App\Util\Enum\StatusHttp;
use Mezzio\Router\RouteResult;
use App\Service\Response\ApiResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use App\Exception\AuthorizationException;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;

use function assert;
use function in_array;

class AuthMiddleware implements MiddlewareInterface
{
    /**
     * @var array
     */
    private $apiKeys;

    /**
     * @var array
     */
    private $openRoutes;

    public function __construct(
        array $apiKeys,
        array $openRoutes
    ) {
        $this->apiKeys = $apiKeys;
        $this->openRoutes = $openRoutes;
    }

    /**
     * @param ServerRequestInterface $request
     * @param RequestHandlerInterface $handler
     * @return ResponseInterface
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            $this->validate($request);
        } catch (AuthorizationException $e) {
            return new ApiResponse($e->getCustomError(), $e->getCode(), ApiResponse::ERROR);
        } catch (Exception $e) {
            return new ApiResponse($e->getMessage(), $e->getCode(), ApiResponse::ERROR);
        }

        return $handler->handle($request);
    }

    /**
     * @param ServerRequestInterface $request
     * @throws AuthorizationException
     */
    private function validate(ServerRequestInterface $request): void
    {
        $route = $request->getAttribute(RouteResult::class);
        assert($route instanceof RouteResult);

        $routeName  = $route->getMatchedRouteName();
        $httpMethod = $request->getMethod();

        if (empty($routeName)) {
            return;
        }

        if (in_array($routeName, $this->openRoutes, true)) {
            return;
        }

        if (!$request->hasHeader('x-api-key')) {
            throw new AuthorizationException(
                StatusHttp::UNAUTHORIZED,
                'Não encontrado chave de autorização no header!'
            );
        }

        $key = $request->getHeader('x-api-key')[0];

        if (!(new \Laminas\Validator\Uuid)->isValid($key) ) {
            throw new AuthorizationException(
                StatusHttp::UNAUTHORIZED,
                'Token API KEY não é válido!'
            );
        }
    }
}
