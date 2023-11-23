<?php

declare(strict_types=1);

use DataBase\Migrations\CreateContactsTable;
use DataBase\Migrations\CreateMigrationsTable;
use DataBase\Migrations\CreateUsersTable;

return [
    CreateMigrationsTable::class,
    CreateUsersTable::class,
    CreateContactsTable::class,
];