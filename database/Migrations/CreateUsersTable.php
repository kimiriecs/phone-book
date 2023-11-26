<?php

declare(strict_types=1);

namespace Database\Migrations;

use App\Core\Database\Migration\Migration;

/**
 * Class CreateUsersTable
 *
 * @package App\Core\Database\Migrations
 */
class CreateUsersTable extends Migration
{
    public function run(): void
    {
        $query = "CREATE TABLE users("
            . "id         BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY, "
            . "first_name VARCHAR(255), "
            . "last_name  VARCHAR(255), "
            . "email      VARCHAR(255) UNIQUE                 NOT NULL, "
            . "password   VARCHAR(255)                        NOT NULL, "
            . "created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL);";

        $this->execute($query);
    }

    public function back(): void
    {
        $query = "DROP TABLE IF EXISTS users;";

        $this->execute($query);
    }
}