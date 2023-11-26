<?php

declare(strict_types=1);

namespace Database\Seeders;

use App\Core\App;
use App\Core\Database\Seeder\Seeder;
use DateTime;
use Exception;
use Modules\Contact\Interfaces\Repositories\ContactRepositoryInterface;
use Modules\User\Entities\User;
use Modules\User\Interfaces\Repositories\UserRepositoryInterface;

/**
 * Class ContactsTableSeeder
 *
 * @package Database\Seeders
 */
class ContactsTableSeeder extends Seeder
{
    /**
     * @return void
     * @throws Exception
     */
    public function run(): void
    {
        /** @var UserRepositoryInterface $userRepository */
        $userRepository = App::instance()->make(UserRepositoryInterface::class);

        /** @var ContactRepositoryInterface $contactRepository */
        $contactRepository = App::instance()->make(ContactRepositoryInterface::class);

        $users = $userRepository->findAll();

        $usersIds = array_map(function (User $user) {
            return $user->getId();
        }, $users);

        $contactsCount = 100;
        $contacts = [];

        for ($contactIndex = 1; $contactIndex <= $contactsCount; $contactIndex++) {
            $contacts[] = [
                'user_id' => $usersIds[array_rand($usersIds)],
                'first_name' => "Contact #$contactIndex first name",
                'last_name' => "Contact #$contactIndex last name",
                'phone' => '+380' . random_int(63, 99) . random_int(100, 999) . random_int(1000, 9999),
                'email' => "contact$contactIndex@example.com",
                'created_at' => (new DateTime)->format('Y-m-d H:i:s'),
            ];
        }

        $quizesEntities = $contactRepository->insertMany($contacts);
    }
}