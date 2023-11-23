<?php

declare(strict_types=1);

namespace App\Core\Database\Migration\Actions;

use App\Core\App;

/**
 * Class IsTableExists
 *
 * @package App\Core\Database\Migration\Actions
 */
class IsTableExists
{
    /**
     * @param string $table
     * @return bool
     */
    public function execute(string $table): bool
    {
        $pdo = App::db()->connect();

        $tableSchema = App::env()->get('DB_DATABASE');

        $query = "SELECT count(*) FROM information_schema.TABLES "
            . "WHERE (TABLE_SCHEMA = '$tableSchema') "
            . "AND (TABLE_TYPE = 'BASE TABLE') "
            . "AND (TABLE_NAME = '$table');";

        $statement = $pdo->prepare($query);
        $success = $statement->execute();
        if (!$success) {
            return false;
        }

        return (bool)$statement->fetchColumn();
    }
}