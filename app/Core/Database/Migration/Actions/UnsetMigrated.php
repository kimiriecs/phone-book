<?php

declare(strict_types=1);

namespace App\Core\Database\Migration\Actions;

use App\Core\App;
use App\Core\Database\Actions\MakeQueryInTransaction;
use App\Core\Database\Migration\MigrationRegister;
use App\Core\ErrorHandler\ErrorHandler;
use Throwable;

/**
 * Class UnsetMigrated
 *
 * @package App\Core\Database\Migration\Actions
 */
class UnsetMigrated
{
    /**
     * @param MakeQueryInTransaction $query
     */
    public function __construct(
        protected MakeQueryInTransaction $query
    ) {
    }

    /**
     * @param array $rolledBack
     * @return bool
     */
    public function execute(array $rolledBack): bool
    {
        $values = [];
        $placeholders = [];
        foreach ($rolledBack as $index => $class) {
            $placeholder = ":name$index";
            $values[$placeholder] = $class;
            $placeholders[] = $placeholder;
        }

        $placeholders = implode(',', $placeholders);

        $table = MigrationRegister::TABLE;
        $column = MigrationRegister::NAME_COLUMN;
        $query = "DELETE FROM $table WHERE $column in ($placeholders);";

        return $this->query->execute($query, $values);
    }
}