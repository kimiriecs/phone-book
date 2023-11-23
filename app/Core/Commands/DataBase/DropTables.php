<?php

declare(strict_types=1);

namespace App\Core\Commands\DataBase;

use App\Core\App;
use App\Core\Commands\Command;
use App\Core\Commands\Common\ListCommands;
use App\Core\Database\Migration\Migration;
use App\Core\Database\Migration\MigrationRegister;

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
        $toDrop = MigrationRegister::toRollback();
        if (empty($toDrop)) {
            echo ListCommands::GREEN . "Nothing to drop..." . ListCommands::RESET . "\n";
            exit();
        }

        foreach ($toDrop as $migrationClass) {
            /** @var Migration $migration */
            $migration = App::instance()->make($migrationClass);

            $migration->back();
            echo ListCommands::GREEN . "$migrationClass was dropped..." . ListCommands::RESET . "\n";
        }

        if (!MigrationRegister::tableExists(MigrationRegister::TABLE)) {
            echo ListCommands::GREEN . "The last migration was dropped..." . ListCommands::RESET . "\n";
            exit();
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