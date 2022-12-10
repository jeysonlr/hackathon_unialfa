<?php

declare(strict_types=1);

namespace App\DTO\Pagination;

use JMS\Serializer\Annotation\Type;

class RequestFilters
{
    /**
     * @var string
     * @Type("string")
     */
    private $orderby;

    /**
     * @var int
     * @Type("int")
     */
    private $limit;

    /**
     * @var int
     * @Type("int")
     */
    protected $offset;

    /**
     * @return string|null
     */
    public function getOrderBy(): ?string
    {
        return $this->orderby;
    }

    /**
     * @param string|null $orderby
     */
    public function setOrderBy(?string $orderby): void
    {
        $this->orderby = $orderby;
    }

    /**
     * @return int|null
     */
    public function getLimit(): ?int
    {
        return $this->limit;
    }

    /**
     * @param int|null $limit
     */
    public function setLimit(?int $limit): void
    {
        $this->limit = $limit;
    }

    /**
     * @return int|null
     */
    public function getOffSet(): ?int
    {
        return $this->offset;
    }

    /**
     * @param int|null $offset
     */
    public function setOffSet(?int $offset): void
    {
        $this->offset = $offset;
    }
}
