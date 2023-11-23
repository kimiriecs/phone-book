<?php

declare(strict_types=1);

namespace App\Core\Commands\DataBase;

use App\Core\App;
use App\Core\Commands\Command;
use App\Core\Commands\Common\ListCommands;
use App\Core\Database\Migration\Migration;
use App\Core\Database\Migration\MigrationRegister;

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
        $toMigrate = MigrationRegister::toMigrate();
        if (empty($toMigrate)) {
            echo ListCommands::GREEN . "Nothing to migrate..." . ListCommands::RESET . "\n";
            exit();
        }

        $migrated = [];
        foreach ($toMigrate as $migrationClass) {
            /** @var Migration $migration */
            $migration = App::instance()->make($migrationClass);
            $migration->run();
            $migrated[] = $migrationClass;
            echo ListCommands::GREEN . "$migrationClass was migrated..." . ListCommands::RESET . "\n";
        }

        MigrationRegister::setMigrated($migrated);
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