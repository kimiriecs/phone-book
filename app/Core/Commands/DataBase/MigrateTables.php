<?php

declare(strict_types=1);

namespace App\Core\Commands\DataBase;

use App\Core\App;
use App\Core\Commands\Command;
use App\Core\Database\Migration;
use App\Core\Helpers\Path;

/**
 * Class MigrateTables
 *
 * @package App\Core\Commands
 */
class MigrateTables extends Command
{
    /**
     * @param array $args
     * @return void
     */
    public function run(array $args): void
    {
        $migrations = require Path::migrations('register');

        foreach ($migrations as $migrationClass) {
            /** @var Migration $migration */
            $migration = App::instance()->make($migrationClass);

            $migration->run();
        }
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return 'db:migrate';
    }

    /**
     * @return string
     */
    public function description(): string
    {
        return 'run migrations';
    }
}