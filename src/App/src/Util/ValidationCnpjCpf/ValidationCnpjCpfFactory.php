<?php

declare(strict_types=1);

namespace App\Util\ValidationCnpjCpf;

use Psr\Container\ContainerInterface;
use App\Util\ValidationCnpjCpf\ValidationCnpjCpf;

class ValidationCnpjCpfFactory
{
    public function __invoke(ContainerInterface $container): ValidationCnpjCpf
    {
        return new ValidationCnpjCpf();
    }
}
