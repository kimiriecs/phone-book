<?php

declare(strict_types=1);

namespace App\Core\Database\Seeder;

use Database\Seeders\ContactsTableSeeder;
use Database\Seeders\UsersTableSeeder;

/**
 * Class MigrationRegister
 *
 * @package App\Core\Database\Migration
 */
class SeederRegister
{
    const SEEDERS = [
        UsersTableSeeder::class,
        ContactsTableSeeder::class,
    ];

    /**
     * @return string[]
     */
    public static function list(): array
    {
        return self::SEEDERS;
    }
}