<?php

declare(strict_types=1);

namespace App\Util\Enum;

class ErrorMessage
{
    # Erro ao consultar um registro
    const ERROR_QUERY_A_RECORD = "Ocorreu um erro ao consultar ";

    # Erro ao consultar todos os resgitros
    const ERROR_QUERY_ALL_RECORD = "Ocorreu um erro ao consultar todos os dados!";

    # Erro ao inserir registro
    const ERROR_INSERTING_RECORD = "Ocorreu um erro ao inserir os dados!";

    # Erro ao inserir registro
    const ERROR_REGISTRY_CHANGE = "Ocorreu um erro ao alterar os dados ";

    # Erro ao deletar um arquivo
    const ERROR_DELETING_RECORD = "Ocorreu um erro ao deletar os dados ";

    # Erro ao desserializar uma entidade/DTO
    const ERROR_DESERIALIZATION = "Ocorreu um erro ao desserializar ";

    # Erro de registro não encontrado
    const ERROR_REGISTER_NOT_FOUND = "Registro com id %s não encontrado!";

    # Erro de usuário não encontrado
    const ERROR_USER_NOT_FOUND = "Usuário não encontrado!";

    # Erro de login
    const ERROR_LOGIN_OR_PASSWORD_INCORRECT = "Login ou senha incorretos!";

    # Erro de insert de cidade
    const ERROR_CITY_DUPLICATED = "Esta cidade já esta cadastrada para o estadoid %s!";

    # Erro de insert de estado
    const ERROR_STATE_DUPLICATED = "Este estado já esta cadastrado!";
}
