<?php

declare(strict_types=1);

namespace App\Core\Commands\Database;

use App\Core\App;
use App\Core\Commands\Command;
use App\Core\Commands\Common\ListCommands;
use App\Core\Database\Seeder\Seeder;
use App\Core\Database\Seeder\SeederRegister;

/**
 * Class SeedTables
 *
 * @package App\Core\Commands\Database
 */
class SeedTables extends Command
{
    /**
     * @param array $args
     * @return void
     */
    public function run(array $args): void
    {
        $seeders = SeederRegister::list();
        if (empty($seeders)) {
            echo ListCommands::GREEN . "Nothing to seed..." . ListCommands::RESET . "\n";
            exit();
        }

        $seeded = [];
        foreach ($seeders as $seederClass) {
            /** @var Seeder $seeder */
            $seeder = App::instance()->make($seederClass);
            $seeder->run();
            echo ListCommands::GREEN . "$seederClass was seeded..." . ListCommands::RESET . "\n";
        }
    }

    /**
     * @return string
     */
    public function name(): string
    {
        return 'db:seed';
    }

    /**
     * @return string
     */
    public function description(): string
    {
        return 'run seeders';
    }
}