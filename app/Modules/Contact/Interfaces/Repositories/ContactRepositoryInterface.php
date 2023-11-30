<?php

declare(strict_types=1);

namespace Modules\Contact\Interfaces\Repositories;

use App\Core\Entity\Entity;
use App\Core\Interfaces\RepositoryInterface;
use ReflectionException;

/**
 * Interface ContactRepositoryInterface
 *
 * @package Modules\Contact\Interfaces
 */
interface ContactRepositoryInterface extends RepositoryInterface
{
    /**
     * @param int $userId
     * @param array|null $filter
     * @param array|null $sort
     * @return Entity[]
     * @throws ReflectionException
     */
    public function findAllUserContacts(int $userId, ?array $filter = [], ?array $sort = []): array;
}