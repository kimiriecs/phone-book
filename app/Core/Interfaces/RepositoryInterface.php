<?php declare(strict_types=1);

namespace App\Core\Interfaces;

use App\Core\Entity\Entity;
use PDO;

/**
 * Interface RepositoryInterface
 *
 * @package App\Core\Interfaces
 */
interface RepositoryInterface
{
    /**
     * @return string
     */
    public function getEntityClass(): string;

    /**
     * @return string
     */
    public function getEntityTable(): string;

    /**
     * @param string $connectionName
     * @return void
     */
    public function setConnection(string $connectionName): void;

    /**
     * @return PDO
     */
    public function connection(): PDO;

    /**
     * @return void
     */
    public function transaction(): void;

    /**
     * @return void
     */
    public function commit(): void;

    /**
     * @return void
     */
    public function rollback(): void;

    /**
     * @param array|null $sort
     * @param array|null $filter
     * @return array<Entity>
     */
    public function findAll(?array $filter = [], ?array $sort = []): array;

    /**
     * @param array $params
     * @return bool
     */
    public function exists(array $params): bool;

    /**
     * @param int $id
     * @return Entity|null
     */
    public function findById(int $id): ?Entity;

    /**
     * @param array $params
     * @return Entity|null
     */
    public function findOneBy(array $params): ?Entity;

    /**
     * @param array $data
     * @return Entity|null
     */
    public function insert(array $data): ?Entity;

    /**
     * @param array $data
     * @return array|null
     */
    public function insertMany(array $data): ?array;

    /**
     * @param int $id
     * @param array $data
     * @return Entity|null
     */
    public function update(int $id, array $data): ?Entity;

    /**
     * @param Entity $entity
     * @return bool
     */
    public function delete(Entity $entity): bool;
}