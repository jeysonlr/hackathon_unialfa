<?php

declare(strict_types=1);

namespace App\Util\Enum;

class SuccessMessage
{
    const SAVED_RECORD = "O registro foi salvo com sucesso!";
    const RECORD_CHANGED = "O registro foi alterado com sucesso!";
    const RECORD_CANCELED = "O registro foi cancelado com sucesso!";
    const DELETING_RECORD = "O registro %s foi deletado com sucesso!";
}