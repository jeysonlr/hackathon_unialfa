<?php

declare(strict_types=1);

namespace Academy\Authentication\Middleware;

use Throwable;
use App\Util\Enum\StatusHttp;
use App\Service\Response\ApiResponse;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Server\MiddlewareInterface;
use Psr\Http\Message\ServerRequestInterface;
use Psr\Http\Server\RequestHandlerInterface;
use Academy\Authentication\Exception\ExpiredTokenException;
use Academy\Authentication\Exception\InvalidTokenException;
use Academy\Authentication\Service\AuthenticationTokenService;
use Academy\Authentication\Exception\CheckSignatureInvalidException;
use Academy\Authentication\Exception\RouteNotAuthorizedOrNotExistsException;

class AuthenticationTokenMiddleware implements MiddlewareInterface
{
    /**
     * @var array
     */
    private $routes;

    /**
     * @var AuthenticationTokenService
     */
    private $authenticationTokenService;

    /**
     * @var array
     */
    private $dataUser;

    public function __construct(
        array $routes,
        AuthenticationTokenService $authenticationTokenService,
        array $dataUser
    ) {
        $this->routes = $routes;
        $this->authenticationTokenService = $authenticationTokenService;
        $this->dataUser = $dataUser;
    }

    /**
     * @param ServerRequestInterface  $request
     * @param RequestHandlerInterface $handler
     *
     * @return ResponseInterface
     * @throws CheckSignatureInvalidException
     * @throws ExpiredTokenException
     * @throws InvalidTokenException
     * @throws RouteNotAuthorizedOrNotExistsException
     */
    public function process(ServerRequestInterface $request, RequestHandlerInterface $handler): ResponseInterface
    {
        try {
            $routeName = strval(
                $request->getAttribute('Mezzio\Router\RouteResult')->getMatchedRouteName()
            );
            $tokenDecoded = $this->authenticate($request->getHeaders(), $routeName);
        } catch (CheckSignatureInvalidException $e) {
        } catch (ExpiredTokenException $e) {
            return new ApiResponse($e->getCustomError(), $e->getCode());
        } catch (InvalidTokenException $e) {
            return new ApiResponse($e->getCustomError(), $e->getCode());
        } catch (RouteNotAuthorizedOrNotExistsException $e) {
            return new ApiResponse($e->getCustomError(), $e->getCode());
        } catch (Throwable $e) {
            return new ApiResponse($e->getMessage(), $e->getCode());
        }

        return $handler->handle($request->withAttribute('tokenDecoded', $tokenDecoded));
    }

    /**
     * @param array       $headers
     * @param string|null $requestRoute
     *
     * @return object|null
     * @throws CheckSignatureInvalidException
     * @throws ExpiredTokenException
     * @throws InvalidTokenException
     * @throws RouteNotAuthorizedOrNotExistsException
     */
    public function authenticate(array $headers, ?string $requestRoute): ?object
    {
        $this->validateIfRouteExists($requestRoute);

        $routeAuthorizedUsers = $this->routes[$requestRoute];
        $keyRequest = $headers['authorization'] ?? null;

        if (!$keyRequest && !$routeAuthorizedUsers) {
            return null;
        }

        $this->validateIfTokenIsRequired($keyRequest, $routeAuthorizedUsers);

        return $this->validateTokenAndUser($keyRequest, $routeAuthorizedUsers);
    }

    /**
     * @param string $requestRoute
     * @throws RouteNotAuthorizedOrNotExistsException
     */
    private function validateIfRouteExists(string $requestRoute): void
    {
        if (empty($requestRoute) || !key_exists($requestRoute, $this->routes)) {
            throw new RouteNotAuthorizedOrNotExistsException(
                StatusHttp::UNAUTHORIZED,
                'Rota não encontrada ou não permitida'
            );
        }
    }

    /**
     * @param array|null $keyRequest
     * @param array|null $routeAuthorizedUsers
     * @throws RouteNotAuthorizedOrNotExistsException
     */
    private function validateIfTokenIsRequired(?array $keyRequest, ?array $routeAuthorizedUsers): void
    {
        if (!$keyRequest && $routeAuthorizedUsers) {
            throw new RouteNotAuthorizedOrNotExistsException(
                StatusHttp::UNAUTHORIZED,
                'O token é obrigatório na requisição!'
            );
        }
    }

    /**
     * @param array|null $keyRequest
     * @param array|null $routeAuthorizedUsers
     *
     * @return object
     * @throws InvalidTokenException
     * @throws CheckSignatureInvalidException
     * @throws ExpiredTokenException
     */
    private function validateTokenAndUser(?array $keyRequest, ?array $routeAuthorizedUsers): object
    {
        $valueRequest = $keyRequest[0];
        list($jwtToken) = sscanf($valueRequest, 'Bearer %s');

        if (!$jwtToken) {
            throw new InvalidTokenException(
                StatusHttp::UNAUTHORIZED,
                'O token informado na requisição está inválido!'
            );
        }

        $tokenDecoded = $this->authenticationTokenService->decode($jwtToken);

        $userType = $this->dataUser['user_type'][$tokenDecoded->data->type];

        if ($routeAuthorizedUsers && !in_array($userType, $routeAuthorizedUsers)) {
            throw new InvalidTokenException(
                StatusHttp::UNAUTHORIZED,
                'Rota não permitida para o usuário portador do token'
            );
        }

        return $tokenDecoded;
    }
}
