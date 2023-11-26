<?php

declare(strict_types=1);

namespace App\Core\Commands;

use App\Core\Commands\Common\ListCommands;
use App\Core\Commands\Database\DropTables;
use App\Core\Commands\Database\MigrateTables;
use App\Core\Commands\Database\RollbackTables;
use App\Core\Commands\Database\SeedTables;

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
        SeedTables::class,
    ];

    /**
     * @return string[]
     */
    public static function list(): array
    {
        return self::COMMANDS;
    }
}