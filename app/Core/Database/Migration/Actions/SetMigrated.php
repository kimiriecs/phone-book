<?php

declare(strict_types=1);

namespace App\Core\Database\Migration\Actions;

use App\Core\App;
use App\Core\Database\Migration\MigrationRegister;
use App\Core\ErrorHandler\ErrorHandler;
use Throwable;

/**
 * Class SetMigrated
 *
 * @package App\Core\Database\Migration\Actions
 */
class SetMigrated
{
    /**
     * @param array $migrated
     * @return bool
     */
    public function execute(array $migrated): bool
    {
        try {
            $pdo = App::db()->connect();
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

            $pdo->beginTransaction();
            $statement = $pdo->prepare($query);
            $success = $statement->execute($values);

            if ($pdo->inTransaction()) {
                $pdo->commit();
            }

            return $success;
        } catch (Throwable $e) {
            ErrorHandler::handleExceptions($e);
        }
    }
}