<?php

declare(strict_types=1);

namespace Modules\User\Repositories;

use App\Core\Database\BaseRepository;
use Modules\User\Entities\User;
use Modules\User\Interfaces\Repositories\UserRepositoryInterface;

/**
 * Class UserRepository
 *
 * @package Modules\User\Repositories
 */
class UserRepository extends BaseRepository implements UserRepositoryInterface
{
    /**
     * @return string
     */
    public function getEntityClass(): string
    {
        return User::class;
    }

    /**
     * @return string
     */
    public function getEntityTable(): string
    {
        return User::TABLE_NAME;
    }
}