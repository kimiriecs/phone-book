<?php

declare(strict_types=1);

namespace App\Core\Commands\Common;

use App\Core\App;
use App\Core\Commands\Command;
use App\Core\Commands\CommandRegister;

/**
 * Class ListCommands
 *
 * @package App\Core\Commands
 */
class ListCommands extends Command
{
    const RED = "\033[31m";
    const GREEN = "\033[32m";
    const YELLOW = "\033[33m";
    const BLUE = "\033[34m";
    const PURPLE = "\033[35m";
    const CYAN = "\033[36m";
    const WHITE = "\033[37m";
    const RESET = "\033[0m";

    /**
     * @param array $args
     * @return void
     */
    public function run(array $args): void
    {
        $commands = CommandRegister::list();
        $list = [];
        foreach ($commands as $commandClass) {
            /** @var Command $command */
            $command = App::instance()->make($commandClass);
            $list[$command->getName()] = $command->getDescription();
        }


        $maxNameLength = max(
            array_map('strlen', array_keys($list))
        );

        foreach ($list as $name => $description) {
            $name = str_pad($name, $maxNameLength, " ");
            $name = self::GREEN . $name . self::RESET;
            $description = self::YELLOW . $description . self::RESET;
            echo "$name\t$description\n";
        }
    }

    /**
     * @return string
     */
    public function name(): string
    {

        return 'list';
    }

    /**
     * @return string
     */
    public function description(): string
    {
        return 'show list of available commands';
    }
}