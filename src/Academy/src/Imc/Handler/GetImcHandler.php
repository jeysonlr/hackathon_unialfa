<?php

declare(strict_types=1);

namespace Academy\Imc\Handler;

use Academy\Imc\DTO\ImcCollection;
use Academy\Imc\DTO\ImcResponse;
use Academy\Imc\Exception\ImcDatabaseException;
use Academy\Imc\Service\ImcServiceInterface;
use Academy\User\DTO\UserResponse;
use Academy\User\Exception\UserDatabaseException;
use Academy\User\Service\GetUserService;
use DateTime;
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

    /**
     * @var ImcServiceInterface
     */
    private $getUserService;

    public function __construct(ImcServiceInterface $imcService, GetUserService $getUserService)
    {
        $this->imcService = $imcService;
        $this->getUserService = $getUserService;
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     */
    public function handle(ServerRequestInterface $request): ResponseInterface
    {
        try {
            $params = $request->getQueryParams();
            $profissionalId = $params['profissionalId'] ?? null;
            $clientId = $params['clientId'] ?? null;
            $initialDate =  $params['initialDate'] ?? null;
            $finalDate =  $params['finalDate'] ?? null;

            $imcResults = $this->imcService->findAll();

            if(!is_null($profissionalId)) {
                $imcResults->filterByProfissional((int)$profissionalId);
            }

            if(!is_null($clientId)) {
                $imcResults->filterByClient((int)$clientId);
            }

            if(!is_null($initialDate) && !is_null($finalDate)) {
                $initialDate = DateTime::createFromFormat('Y-m-d', $initialDate);
                $finalDate = DateTime::createFromFormat('Y-m-d', $finalDate);
                $imcResults->filterByPeriod($initialDate, $finalDate);
            }

            $response = !empty($imcResults) ? $this->fillName($imcResults->toArray()) : [];

            return new ApiResponse($response, StatusHttp::OK, ApiResponse::SUCCESS);
        } catch (ImcDatabaseException $e) {
            return new ApiResponse($e->getMessage(), $e->getCode(), ApiResponse::ERROR, null, $e);
        } catch (BaseException $e) {
            return new ApiResponse($e->getCustomError(), $e->getCode(), ApiResponse::ERROR, null, $e);
        } catch (Throwable $e) {
            return new ApiResponse($e->getMessage(), $e->getCode(), ApiResponse::ERROR, null, $e);
        }
    }

    private function fillName(array $results): array
    {
        return array_map(function($item){
            $profissional = $this->getUserService->getUserById((int)$item['profissionalId']);
            $client = $this->getUserService->getUserById((int)$item['clientId']);

            $item['profissionalName'] = !is_null($profissional) ?  $profissional->getName() : '';
            $item['clientName'] = !is_null($client) ? $client->getName() : '';

            return $item;

        }, $results);
    }

    /**
     * @throws UserDatabaseException
     */
    private function getUser($userId): ?UserResponse
    {
        return $this->getUserService->getUserById($userId);
    }
}
