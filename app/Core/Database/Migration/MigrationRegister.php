<?php

declare(strict_types=1);

namespace App\Core\Database\Migration;

use App\Core\App;
use App\Core\Database\Migration\Actions\GetMigrated;
use App\Core\Database\Migration\Actions\IsTableExists;
use App\Core\Database\Migration\Actions\SetMigrated;
use App\Core\Database\Migration\Actions\UnsetMigrated;
use DataBase\Migrations\CreateContactsTable;
use DataBase\Migrations\CreateMigrationsTable;
use DataBase\Migrations\CreateUsersTable;

/**
 * Class MigrationRegister
 *
 * @package App\Core\Database\Migration
 */
class MigrationRegister
{
    const TABLE = 'migrations';
    const NAME_COLUMN = 'name';
    const ORDER_COLUMN = 'id';

    const MIGRATIONS = [
        CreateMigrationsTable::class,
        CreateUsersTable::class,
        CreateContactsTable::class,
    ];

    /**
     * @return string[]
     */
    public static function list(): array
    {
        return self::MIGRATIONS;
    }

    /**
     * @return string[]
     */
    public static function toMigrate(): array
    {
        return array_diff(self::MIGRATIONS, self::getMigrated());
    }

    /**
     * @return string[]
     */
    public static function getMigrated(?bool $desc = false): array
    {
        /** @var GetMigrated $action */
        $action = App::instance()->make(GetMigrated::class);

        return $action->execute($desc);
    }

    /**
     * @return string[]
     */
    public static function toRollback(?int $steps = null): array
    {
        $migrations = self::getMigrated(true);

        return array_slice($migrations, 0, $steps);
    }

    /**
     * @param string $table
     * @return bool
     */
    public static function tableExists(string $table): bool
    {
        /** @var IsTableExists $action */
        $action = App::instance()->make(IsTableExists::class);

        return $action->execute($table);
    }

    /**
     * @param array $migrated
     * @return bool
     */
    public static function setMigrated(array $migrated): bool
    {
        /** @var SetMigrated $action */
        $action = App::instance()->make(SetMigrated::class);

        return $action->execute($migrated);
    }

    /**
     * @param array $rolledBack
     * @return bool
     */
    public static function unsetMigrated(array $rolledBack): bool
    {
        /** @var UnsetMigrated $action */
        $action = App::instance()->make(UnsetMigrated::class);

        return $action->execute($rolledBack);
    }
}