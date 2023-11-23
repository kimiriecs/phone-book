<?php

declare(strict_types=1);

namespace App\Core\Database\Migration\Actions;

use App\Core\App;
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
     * @param array $rolledBack
     * @return bool
     */
    public function execute(array $rolledBack): bool
    {
        try {
            $pdo = App::db()->connect();

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
            $pdo->beginTransaction();

            $deleteQuery = "DELETE FROM $table WHERE $column in ($placeholders);";
            $statement = $pdo->prepare($deleteQuery);
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