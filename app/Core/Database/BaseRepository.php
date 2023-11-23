<?php

declare(strict_types=1);

namespace App\Core\Database;

use App\Core\App;
use App\Core\Entity\Entity;
use App\Core\Interfaces\RepositoryInterface;
use PDO;
use PDOStatement;
use ReflectionException;

/**
 * Class BaseRepository
 *
 * @package App\Core\Database
 */
abstract class BaseRepository implements RepositoryInterface
{
    /**
     * @return string
     */
    abstract public function getEntityClass(): string;

    /**
     * @return string
     */
    abstract public function getEntityTable(): string;

    /**
     * @param string $connectionName
     * @return void
     */
    public function setConnection(string $connectionName): void
    {
        App::db()->connect($connectionName);
    }

    /**
     * @return PDO
     */
    public function connection(): PDO
    {
        return App::db()->connect();
    }

    /**
     * @param string $query
     * @return false|PDOStatement
     */
    protected function getPreparedStatement(string $query): false|PDOStatement
    {
        return $this->connection()->prepare($query);
    }

    /**
     * @param array|null $sort
     * @param array|null $filter
     * @return array<Entity>
     * @throws ReflectionException
     */
    public function findAll(?array $filter = [], ?array $sort = []): array
    {
        $table = $this->getEntityTable();
        $query = "SELECT * FROM $table";

        //TODO: implement filters for each entity, dependently on field ( add iLIKE '%asd%' )
        if ($filter) {
            $query = $this->addParametersToQuery($query, $filter);
        }

        if ($sort) {
            $queryParts = [];
            foreach ($sort as $sortBy => $sortDirection) {
                $queryParts[] = $sortBy . ' ' . (strtoupper($sortDirection) === 'DESC' ? 'DESC' : 'ASC');
            }
            $query .= " ORDER BY " . implode(', ', $queryParts);
        }

        $statement = $this->getPreparedStatement($query);
        if ($filter) {
            $statement->execute($filter);
        } else {
            $statement->execute();
        }

        $result = $statement->fetchAll();

        if (false === $result) {
            return [];
        }

        $entities = [];
        foreach ($result as $row) {
            $entities[] = EntityReflector::getEntity($this->getEntityClass(), $row);
        }

        return $entities;
    }

    /**
     * @param array $params
     * @return bool
     */
    public function exists(array $params): bool
    {
        $table = $this->getEntityTable();

        $query = "SELECT EXISTS(SELECT 1 FROM $table";
        $query = $this->addParametersToquery($query, $params);
        $query .= ")";
        $statement = $this->getPreparedStatement($query);
        $statement->execute($params);

        return (bool) $statement->fetchColumn();
    }

    /**
     * @param int $id
     * @return Entity|null
     * @throws ReflectionException
     */
    public function findById(int $id): ?Entity
    {
        $table = $this->getEntityTable();
        $query = "SELECT * FROM $table WHERE id = :id";
        $statement = $this->getPreparedStatement($query);
        $statement->execute(['id' => $id]);

        $result = $statement->fetch();

        if (false === $result) {
            return null;
        }

        return EntityReflector::getEntity($this->getEntityClass(), $result);
    }

    /**
     * @param array $params
     * @return Entity|null
     * @throws ReflectionException
     */
    public function findOneBy(array $params): ?Entity
    {
        $params = array_map(function ($item) {
            if (is_bool($item)) {
                return $item ? 'true' : 'false';
            }
            return $item;
        }, $params);

        $table = $this->getEntityTable();
        $query = "SELECT * FROM $table";
        $query = $this->addParametersToQuery($query, $params);
        $statement = $this->getPreparedStatement($query);
        $statement->execute($params);
        $result = $statement->fetch();

        if ($result === false) {
            return null;
        }

        return EntityReflector::getEntity($this->getEntityClass(), $result);
    }

    /**
     * @param array $ids
     * @return array|null
     * @throws ReflectionException
     */
    public function whereIn(array $ids): ?array
    {
        $table = $this->getEntityTable();
        $placeholders = implode(',', array_fill(0, count($ids), '?'));
        $query = "SELECT * FROM $table WHERE id IN ($placeholders)";
        $statement = $this->getPreparedStatement($query);
        $statement->execute($ids);

        $result = $statement->fetchAll();

        if ($result === false) {
            return null;
        }

        $entities = [];
        foreach($result as $row) {
            $entities[] = EntityReflector::getEntity($this->getEntityClass(), $row);
        }

        return $entities;
    }

    /**
     * @param array $data
     * @return Entity|null
     * @throws ReflectionException
     */
    public function insert(array $data): ?Entity
    {
        $data = array_map(function ($item) {
            if (is_bool($item)) {
                return $item ? 'true' : 'false';
            }
            return $item;
        }, $data);

        $table = $this->getEntityTable();
        $columns = array_keys($data);
        $preparedColumns = implode(',', array_keys($data));
        $columnsPlaceholders = $this->getColumnsPlaceholders($columns);
        $query = "INSERT INTO $table (" . $preparedColumns . ") VALUES (" . $columnsPlaceholders . ") RETURNING id";
        $statement = $this->getPreparedStatement($query);
        $success = $statement->execute($data);

        if (!$success) {
            return null;
        }

        $lastInsert = $statement->fetch();

        return $this->findById((int)$lastInsert['id']);
    }

    /**
     * @param array $data
     * @return array<Entity>|null
     * @throws ReflectionException
     */
    public function insertMany(array $data): ?array
    {
        $table = $this->getEntityTable();

        $columns = array_keys($data[0]);
        $preparedColumns = implode(',', array_keys($data[0]));
        $columnsPlaceholders = $this->getColumnsPlaceholders($columns);

        $allValues = [];
        $rows = [];
        foreach ($data as $index => $row) {
            $row = array_map(function ($item) {
                if (is_bool($item)) {
                    return $item ? 'true' : 'false';
                }
                return $item;
            }, $row);

            $keyPairs = [];
            foreach ($row as $column => $value) {
                $param = ':' . $column . $index;
                $keyPairs[] = $param;
                $allValues[$param] = $value;
            }
            $rows[] = '(' . implode(',', $keyPairs) . ')';
        }

        $allPlaceholders = implode(',', $rows);
        $query = "INSERT INTO $table ($preparedColumns) VALUES $allPlaceholders RETURNING id";
        $statement = $this->getPreparedStatement($query);
        $success = $statement->execute($allValues);

        if (!$success) {
            return null;
        }

        $lastIds = $statement->fetchAll(PDO::FETCH_COLUMN, 0);

        return $this->whereIn($lastIds);
    }

    /**
     * @param int $id
     * @param array $data
     * @return Entity|null
     * @throws ReflectionException
     */
    public function update(int $id, array $data): ?Entity
    {
        $data = array_map(function ($item) {
            if (is_bool($item)) {
                return $item ? 'true' : 'false';
            }
            return $item;
        }, $data);

        $table = $this->getEntityTable();
        $columns = $this->getPreparedColumns($data);
        $query = "UPDATE $table SET $columns WHERE id = :id";
        $statement = $this->getPreparedStatement($query);
        $data['id'] = $id;
        $statement->execute($data);

        return $this->findById($id);
    }

    /**
     * @param Entity $entity
     * @return bool
     */
    public function delete(Entity $entity): bool
    {
        $table = $this->getEntityTable();
        $query = "DELETE FROM $table WHERE id = :id";
        $statement = $this->getPreparedStatement($query);

        return $statement->execute(['id' => $entity->getId()]);
    }

    /**
     * @param string $query
     * @param array $params
     * @return string
     */
    private function addParametersToQuery(string $query, array $params): string
    {
        if (!empty($params)) {
            $conditions = [];
            foreach ($params as $key => $value) {
                $conditions[] = "$key = :$key";
            }
            $query .= " WHERE " . implode(" AND ", $conditions);
        }

        return $query;
    }

    /**
     * @param array $data
     * @return string
     */
    private function getPreparedColumns(array $data): string
    {
        $columns = array_keys($data);
        $preparedColumns = '';
        foreach ($columns as $column) {
            $preparedColumns .= $column . ' = :' . $column;
            if (next($columns)) {
                $preparedColumns .= ',';
            }
        }
        return $preparedColumns;
    }

    /**
     * @param array $columns
     * @return string
     */
    private function getColumnsPlaceholders(array $columns): string
    {
        $columnsPlaceholders = '';
        foreach ($columns as $columnPlaceholder) {
            $columnsPlaceholders .= ':' . $columnPlaceholder;
            if (next($columns)) {
                $columnsPlaceholders .= ',';
            }
        }
        return $columnsPlaceholders;
    }
}