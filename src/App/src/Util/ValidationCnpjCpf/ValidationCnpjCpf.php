<?php

declare(strict_types=1);

namespace App\Util\ValidationCnpjCpf;

use Respect\Validation\Validator;
use App\Util\ValidationCnpjCpf\ValidationCnpjCpfInterface;

class ValidationCnpjCpf implements ValidationCnpjCpfInterface
{
    /**
     * Valida se CNPJ/CPF não é vazio, e chama validador de formato
     * @param string $cnpjCpf
     * @return bool
     */
    public function isValidCPFCNPJ(string $cnpjCpf): bool
    {
        return empty($cnpjCpf) ? false : $this->isValidFormat($cnpjCpf);
    }

    /**
     * Verifica o formato e "validade" do CNPJ/CPF
     * @param string $cnpjCpf
     * @return bool
     */
    private function isValidFormat(string $cnpjCpf): bool
    {
        if (strlen($cnpjCpf) == 11) {
            return Validator::cpf()->validate($cnpjCpf);
        }

        if (strlen($cnpjCpf) == 14) {
            return Validator::cnpj()->validate($cnpjCpf);
        }
        return false;
    }
}
