<?php

declare(strict_types=1);

namespace App\Core\Commands;

use App\Core\Commands\Common\ListCommands;
use App\Core\Commands\DataBase\DropTables;
use App\Core\Commands\DataBase\MigrateTables;
use App\Core\Commands\DataBase\RollbackTables;

/**
 * Class CommandRegister
 *
 * @package App\Core\Commands
 */
class CommandRegister
{
    const COMMANDS = [
        ListCommands::class,
        MigrateTables::class,
        RollbackTables::class,
        DropTables::class,
    ];

    /**
     * @return string[]
     */
    public static function list(): array
    {
        return self::COMMANDS;
    }
}