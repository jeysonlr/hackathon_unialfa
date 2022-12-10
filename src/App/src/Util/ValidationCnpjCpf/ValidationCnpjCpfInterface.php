<?php

declare(strict_types=1);

namespace App\Util\ValidationCnpjCpf;

interface ValidationCnpjCpfInterface
{
    /**
     * Valida se CNPJ/CPF não é vazio, e chama validador de formato
     * @param string $cnpjCpf
     * @return bool
     */
    public function isValidCPFCNPJ(string $cnpjCpf): bool;
}
