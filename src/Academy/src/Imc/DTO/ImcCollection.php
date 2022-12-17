<?php

namespace Academy\Imc\DTO;

use DateTime;

final class ImcCollection
{
    /** @var ImcResponse[] $results */
    private $results;

    /**
     * @param ImcResponse[] $results
     */
    public function __construct(array $results = [])
    {
        $this->results = $results;
    }

    public function filterByProfissional(int $profissionalId): void
    {
        $this->filter(function(ImcResponse $item) use ($profissionalId){
            return $item->getProfissionalId() === $profissionalId;
        });
    }

    public function filterByClient(int $clientId): void
    {
        $this->filter(function(ImcResponse $item) use ($clientId){
            return $item->getClientId() === $clientId;
        });
    }

    public function filterByPeriod(DateTime $initialDate, DateTime $finalDate)
    {
        $this->filter(function(ImcResponse $item) use ($initialDate, $finalDate) {

            $createdAt = DateTime::createFromFormat(
                'Y-m-d',
                $item->getCreatedAt()->format('Y-m-d')
            );

            return $initialDate->getTimestamp() >= $createdAt->getTimestamp()
                && $finalDate->getTimestamp() <=  $createdAt->getTimestamp();

        });
    }

    public function filter(callable $callable): void
    {
        $this->results = array_filter($this->results, $callable);
    }

    /**
     * @return ImcResponse[]
     */
    public function all()
    {
        return $this->results;
    }

    /**
     * @return array|array[]
     */
    public function toArray(): array
    {
        return array_values(
            array_map(function($item) {
                return $item->toArray();
            }, $this->results)
        );
    }
}