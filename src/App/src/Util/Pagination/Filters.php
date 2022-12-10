<?php

declare(strict_types=1);

namespace App\Util\Pagination;

use App\Util\Enum\StatusHttp;
use App\DTO\Pagination\RequestFilters;
use App\Exception\FiltersPaginationException;

class Filters
{
    /**
     * @var RequestFilters
     */
    private $requestFilters;

    /**
     * @param array $params
     * @throws FiltersPaginationException
     */
    public function setFilters(array $params): void
    {
        $this->requestFilters = new RequestFilters();
        $this->requestFilters->setOrderBy(isset($params["orderby"]) ? strtoupper($params["orderby"]) : "DESC");
        $this->requestFilters->setOffSet(isset($params["offset"]) ? intval($params["offset"]) : 0);
        $this->requestFilters->setLimit(isset($params["limit"]) ? intval($params["limit"]) : 40);
        $this->validateParams();
    }

    /**
     * @return RequestFilters
     */
    public function getFilters(): RequestFilters
    {
        return $this->requestFilters;
    }

    /**
     * Verifica os filtros da requisição
     * @throws FiltersPaginationException
     */
    private function validateParams(): void
    {
        if ($this->requestFilters->getOffSet() < 0) {
            throw new FiltersPaginationException(
                StatusHttp::BAD_REQUEST,
                "Offset não pode ser menor que 0!"
            );
        }

        if ($this->requestFilters->getLimit() < 0) {
            throw new FiltersPaginationException(
                StatusHttp::BAD_REQUEST,
                "Limit não pode ser menor que 0!"
            );
        }
    }
}
