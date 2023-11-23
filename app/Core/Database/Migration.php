<?php

declare(strict_types=1);

namespace App\Core\Database;

use App\Core\App;
use App\Core\ErrorHandler\ErrorHandler;
use Throwable;

/**
 * Class Migration
 *
 * @package App\Core\Database
 */
class Migration
{
    /**
     * @return void
     */
    public function run(): void
    {
        $this->execute();
    }

    /**
     * @return void
     */
    public function back(): void
    {
        $this->execute();
    }

    /**
     * @param string|null $query
     * @return void
     */
    protected function execute(?string $query = null): void
    {
        if (is_null($query)) {
            return;
        }

        $pdo = App::db()->connect();

        try {
            $pdo->beginTransaction();

            $pdo->prepare($query)->execute();

            if ($pdo->inTransaction()) {
                $pdo->commit();
            }
        } catch (Throwable $e) {
            if ($pdo->inTransaction()) {
                $pdo->rollBack();
            }
            ErrorHandler::handleExceptions($e);
        }
    }
}