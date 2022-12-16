<?php

namespace Academy\Imc\DTO;

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

    /**
     * @return ImcResponse[]
     */
    public function all()
    {
        return $this->results;
    }
}