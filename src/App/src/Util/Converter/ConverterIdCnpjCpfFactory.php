<?php

declare (strict_types=1);

namespace App\Util\Converter;

use Psr\Container\ContainerInterface;

class ConverterIdCnpjCpfFactory
{
    public function __invoke(ContainerInterface $container): ConverterIdCnpjCpf
    {
        return new ConverterIdCnpjCpf();
    }
}
