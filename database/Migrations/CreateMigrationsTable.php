<?php

declare(strict_types=1);

namespace DataBase\Migrations;

use App\Core\Database\Migration\Migration;

/**
 * Class CreateMigrationsTable
 *
 * @package Database\Migrations
 */
class CreateMigrationsTable extends Migration
{
    public function run(): void
    {
        $query = "CREATE TABLE migrations ("
            . "id INT UNSIGNED NOT NULL AUTO_INCREMENT, "
            . "name VARCHAR(255) NOT NULL, "
            . "created_at TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP, "
            . "PRIMARY KEY (id), "
            . "UNIQUE (name)"
            . ") ENGINE = InnoDB;";

        $this->execute($query);
    }

    public function back(): void
    {
        $query = "DROP TABLE IF EXISTS migrations;";

        $this->execute($query);
    }
}