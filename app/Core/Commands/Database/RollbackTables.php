<?php

declare(strict_types=1);

namespace App\Core\Commands\Database;

use App\Core\App;
use App\Core\Commands\Command;
use App\Core\Commands\Common\ListCommands;
use App\Core\Database\Migration\Migration;
use App\Core\Database\Migration\MigrationRegister;

/**
 * Class RollbackTables
 *
 * @package App\Core\Commands\Database
 */
class RollbackTables extends Command
{
    const STEPS_ARGUMENT_POSITION = 2;

    /**
     * @param array $args
     * @return void
     */
    public function run(array $args): void
    {
        $steps = null;
        if (isset($args[self::STEPS_ARGUMENT_POSITION])) {
            $steps = (int) $args[self::STEPS_ARGUMENT_POSITION];
        }

        $toRollback = MigrationRegister::toRollback($steps);
        if (empty($toRollback)) {
            echo ListCommands::GREEN . "Nothing to rollback..." . ListCommands::RESET . "\n";
            exit();
        }

        $rolledBack = [];
        foreach ($toRollback as $migrationClass) {
            /** @var Migration $migration */
            $migration = App::instance()->make($migrationClass);
            $migration->back();
            $rolledBack[] = $migrationClass;
            echo ListCommands::GREEN . "$migrationClass was rolled back..." . ListCommands::RESET . "\n";
        }

        if (!MigrationRegister::tableExists(MigrationRegister::TABLE)) {
            echo ListCommands::GREEN . "The last migration was rolled back..." . ListCommands::RESET . "\n";
            exit();
        }

        MigrationRegister::unsetMigrated($rolledBack);
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return 'db:rollback';
    }

    /**
     * @return string
     */
    public function description(): string
    {
        return 'rollback migrations';
    }
}
