<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Core\App;
use App\Core\Database\Seeder\Seeder;
use DateTime;
use Modules\User\Interfaces\Repositories\UserRepositoryInterface;

/**
 * Class UsersTableSeeder
 *
 * @package Database\Seeders
 */
class UsersTableSeeder extends Seeder
{
    /**
     * @return void
     */
    public function run(): void
    {
        /** @var UserRepositoryInterface $repository */
        $repository = App::instance()->make(UserRepositoryInterface::class);
        $usersCount = 15;
        $users = [];

        for ($userIndex = 1; $userIndex <= $usersCount; $userIndex++) {
            $users[] = [
                'first_name' => "User #$userIndex first name",
                'last_name' => "User #$userIndex last name",
                'email' => "user$userIndex@example.com",
                'password' => password_hash('password', PASSWORD_DEFAULT),
                'created_at' => (new DateTime)->format('Y-m-d H:i:s'),
            ];
        }

        $repository->insertMany($users);
    }
}