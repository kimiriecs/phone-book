<?php

declare(strict_types=1);

namespace App\Core\Commands\DataBase;

use App\Core\App;
use App\Core\Commands\Command;
use App\Core\Database\Migration;
use App\Core\Helpers\Path;

/**
 * Class DropTables
 *
 * @package App\Core\Commands
 */
class DropTables extends Command
{
    /**
     * @param array $args
     * @return void
     */
    public function run(array $args): void
    {
        $migrations = require Path::migrations('register');

        foreach (array_reverse($migrations) as $migrationClass) {
            /** @var Migration $migration */
            $migration = App::instance()->make($migrationClass);

            $migration->back();
        }
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return 'db:drop';
    }

    /**
     * @return string
     */
    public function description(): string
    {
        return 'drop all tables';
    }
}