<?php

declare(strict_types=1);

namespace DataBase\Migrations;

use App\Core\Database\Migration\Migration;

/**
 * Class CreateContactsTable
 *
 * @package DataBase\Migrations
 */
class CreateContactsTable extends Migration
{
    public function run(): void
    {
        $query = "CREATE TABLE contacts("
            . "id         BIGINT NOT NULL AUTO_INCREMENT PRIMARY KEY, "
            . "user_id    BIGINT, "
            . "first_name VARCHAR(255) NOT NULL, "
            . "last_name  VARCHAR(255) NOT NULL, "
            . "phone      VARCHAR(255) NOT NULL, "
            . "email      VARCHAR(255) NOT NULL, "
            . "created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP NOT NULL, "
            . "FOREIGN KEY (user_id) REFERENCES users (id) ON DELETE CASCADE);";

        $this->execute($query);
    }

    public function back(): void
    {
        $query = "DROP TABLE IF EXISTS contacts;";

        $this->execute($query);
    }
}