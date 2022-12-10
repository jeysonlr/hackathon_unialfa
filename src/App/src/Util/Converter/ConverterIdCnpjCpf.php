<?php

declare(strict_types=1);

namespace App\Util\Converter;

use Exception;

class ConverterIdCnpjCpf
{
    /**
     * Converte um idCnpjCpf para um CPF
     * @param int $idCnpjCpf
     * @return string
     */
    public function convertIdCnpjCpfToCPF(int $idCnpjCpf): string
    {
        return substr($idCnpjCpf . "", -11);
    }

    /**
     * Converte um idCnpjCpf para um CNPJ
     * @param int $idCnpjCpf
     * @return string
     */
    public function convertIdCnpjCpfToCnpj(int $idCnpjCpf): string
    {
        return substr($idCnpjCpf . "", -14);
    }

    /**
     * Converte um CNPJ/CPF em idCnpjCpf
     * @param string $cnpjCpf
     * @return int
     */
    public function convertCnpjCpfToIdCnpjCpf(string $cnpjCpf): int
    {
        return intval($cnpjCpf) + 100000000000000;
    }

    /**
     * Adiciona pontuação no CPF
     * @param string $cpf
     * @return string|null
     * @throws Exception
     */
    public function formatCpf(string $cpf): ?string
    {
        $cnpj_cpf = preg_replace("/\D/", '', $cpf);

        if (strlen($cnpj_cpf) !== 11) {
            throw new Exception("CPF inválido!", 400);
        }
        return preg_replace("/(\d{3})(\d{3})(\d{3})(\d{2})/", "\$1.\$2.\$3-\$4", $cpf);
    }

    /**
     * Adiciona pontuação no CNPJ
     * @param string $cnpj
     * @return string|null
     * @throws Exception
     */
    public function formatCnpj(string $cnpj): ?string
    {
        $cnpj_cpf = preg_replace("/\D/", '', $cnpj);

        if (strlen($cnpj_cpf) !== 14) {
            throw new Exception("CNPJ inválido!", 400);
        }

        return preg_replace("/(\d{2})(\d{3})(\d{3})(\d{4})(\d{2})/", "\$1.\$2.\$3/\$4-\$5", $cnpj);
    }
}
