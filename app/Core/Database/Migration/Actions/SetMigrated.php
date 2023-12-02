<?php

declare(strict_types=1);

namespace App\Core\Database\Migration\Actions;

use App\Core\Database\Actions\MakeQueryInTransaction;
use App\Core\Database\Migration\MigrationRegister;

/**
 * Class SetMigrated
 *
 * @package App\Core\Database\Migration\Actions
 */
class SetMigrated
{
    /**
     * @param MakeQueryInTransaction $query
     */
    public function __construct(
        protected MakeQueryInTransaction $query
    ) {
    }

    /**
     * @param array $migrated
     * @return bool
     */
    public function execute(array $migrated): bool
    {
        $values = [];
        $preparedPlaceholders = [];
        foreach ($migrated as $index => $class) {
            $placeholder = ":name$index";
            $values[$placeholder] = $class;
            $preparedPlaceholders[] = "($placeholder)";
        }

        $placeholders = implode(',', $preparedPlaceholders);

        $table = MigrationRegister::TABLE;
        $column = MigrationRegister::NAME_COLUMN;
        $query = "INSERT INTO $table ($column) VALUES $placeholders;";

        return $this->query->execute($query, $values);
    }
}