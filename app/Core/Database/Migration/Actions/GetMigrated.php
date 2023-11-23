<?php

declare(strict_types=1);

namespace App\Core\Database\Migration\Actions;

use App\Core\App;
use App\Core\Database\Migration\MigrationRegister;
use PDO;

/**
 * Class GetMigrated
 *
 * @package App\Core\Database\Migration\Actions
 */
class GetMigrated
{
    /**
     * @param bool|null $desc
     * @return array
     */
    public function execute(?bool $desc = false): array
    {
        if (!MigrationRegister::tableExists(MigrationRegister::TABLE)) {
            return [];
        }

        $pdo = App::db()->connect();

        $table = MigrationRegister::TABLE;
        $searchColumn = MigrationRegister::NAME_COLUMN;
        $orderColumn = MigrationRegister::ORDER_COLUMN;
        $direction = $desc ? 'DESC' : 'ASC';

        $query = "SELECT $searchColumn FROM $table ORDER BY $orderColumn $direction;";

        $statement = $pdo->prepare($query);
        $success = $statement->execute();
        if (!$success) {
            return [];
        }

        return $statement->fetchAll(PDO::FETCH_COLUMN);
    }
}