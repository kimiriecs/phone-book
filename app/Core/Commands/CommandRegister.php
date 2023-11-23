<?php

declare(strict_types=1);

namespace App\Core\Commands;

use App\Core\Commands\Common\ListCommands;

/**
 * Class CommandRegister
 *
 * @package App\Core\Commands
 */
class CommandRegister
{
    const COMMANDS = [
        ListCommands::class,
    ];

    /**
     * @return string[]
     */
    public static function commands(): array
    {
        return self::COMMANDS;
    }
}