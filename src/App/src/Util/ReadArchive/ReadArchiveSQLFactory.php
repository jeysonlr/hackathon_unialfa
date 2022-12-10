<?php

declare(strict_types=1);

namespace App\Util\ReadArchive;

use Psr\Container\ContainerInterface;
use App\Util\ReadArchive\ReadArchiveSQL;

class ReadArchiveSQLFactory
{
    public function __invoke(ContainerInterface $container): ReadArchiveSQL
    {
        return new ReadArchiveSQL();
    }
}
