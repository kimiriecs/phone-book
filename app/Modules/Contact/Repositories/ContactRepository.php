<?php

declare(strict_types=1);

namespace Modules\Contact\Repositories;

use App\Core\Database\BaseRepository;
use App\Core\Entity\Entity;
use App\Modules\Contact\Entities\Contact;
use Modules\Contact\Interfaces\Repositories\ContactRepositoryInterface;
use ReflectionException;

/**
 * Class ContactRepository
 *
 * @package Modules\Contact\Repositories
 */
class ContactRepository extends BaseRepository implements ContactRepositoryInterface
{

    /**
     * @return string
     */
    public function getEntityClass(): string
    {
        return Contact::class;
    }

    /**
     * @return string
     */
    public function getEntityTable(): string
    {
        return Contact::TABLE_NAME;
    }

    /**
     * @param int $userId
     * @param array|null $filter
     * @param array|null $sort
     * @return Entity[]
     * @throws ReflectionException
     */
    public function findAllUserContacts(int $userId, ?array $filter = [], ?array $sort = []): array
    {
        $filter = array_merge($filter ?? [], ['user_id' => $userId]);

        return $this->findAll($filter, $sort);
    }
}