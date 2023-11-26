<?php

declare(strict_types=1);

namespace App\Core\Database\Actions;

use App\Core\App;
use App\Core\ErrorHandler\ErrorHandler;
use Throwable;

/**
 * Class Query
 *
 * @package App\Core\DB\Actions
 */
class MakeQueryInTransaction
{
    /**
     * @param string $query
     * @param array|null $values
     * @return bool
     */
    public function execute(string $query, ?array $values = []): bool
    {
        $pdo = App::db()->connect();

        try {
            $pdo->beginTransaction();

            $pdo->prepare($query);
            $statement = $pdo->prepare($query);
            $success = $statement->execute($values);

            if ($pdo->inTransaction()) {
                $pdo->commit();
            }

            return $success;
        } catch (Throwable $e) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }

            ErrorHandler::handleExceptions($e, false);
        }
    }
}