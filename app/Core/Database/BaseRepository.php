<?php

declare(strict_types=1);

namespace App\Core\Database;

use App\Core\App;
use App\Core\Entity\Entity;
use App\Core\ErrorHandler\ErrorHandler;
use App\Core\Interfaces\RepositoryInterface;
use PDO;
use PDOStatement;
use ReflectionException;
use Throwable;

/**
 * Class BaseRepository
 *
 * @package App\Core\Database
 */
abstract class BaseRepository implements RepositoryInterface
{
    /**
     * @var PDO|null $pdo
     */
    private ?PDO $pdo = null;

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
        if (! $this->pdo) {
            $this->pdo = App::db()->connect();
        }

        return $this->pdo;
    }

    /**
     * @return void
     */
    public function transaction(): void
    {
        $this->connection()->beginTransaction();
    }

    /**
     * @return void
     */
    public function commit(): void
    {
        if ($this->connection()->inTransaction()) {
            $this->connection()->commit();
        }
    }

    /**
     * @return void
     */
    public function rollback(): void
    {
        if ($this->connection()->inTransaction()) {
            $this->connection()->rollBack();
        }
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
     * @return array|null
     * @throws ReflectionException
     */
    public function findBy(array $params): ?array
    {
        $params = array_map(function ($item) {
            if (is_bool($item)) {
                return $item ? 1 : 0;
            }
            return $item;
        }, $params);

        return $this->findAll($params);
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

        return (bool)$statement->fetchColumn();
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
                return $item ? 1 : 0;
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
        $query = "SELECT * FROM $table WHERE id IN ($placeholders);";

        $statement = $this->getPreparedStatement($query);
        $success = $statement->execute($ids);

        if (! $success) {
            return null;
        }

        $result = $statement->fetchAll(PDO::FETCH_ASSOC);

        $entities = [];
        foreach ($result as $row) {
            $entities[] = EntityReflector::getEntity($this->getEntityClass(), $row);
        }

        return $entities;
    }

    /**
     * @param array $data
     * @return Entity|null
     */
    public function insert(array $data): ?Entity
    {
        $data = array_map(function ($item) {
            if (is_bool($item)) {
                return $item ? 1 : 0;
            }
            return $item;
        }, $data);

        $table = $this->getEntityTable();
        $columns = array_keys($data);
        $preparedColumns = implode(',', array_keys($data));
        $columnsPlaceholders = $this->getColumnsPlaceholders($columns);
        $query = "INSERT INTO $table (" . $preparedColumns . ") VALUES (" . $columnsPlaceholders . ") RETURNING id";

        try {
            $this->transaction();
            $statement = $this->getPreparedStatement($query);
            $success = $statement->execute($data);
            $this->commit();

            if (! $success) {
                return null;
            }

            $lastInsert = $statement->fetch();

            return $this->findById((int)$lastInsert['id']);
        } catch (Throwable $e) {
            $this->rollback();

            ErrorHandler::handleExceptions($e);
        }
    }

    /**
     * @param array $data
     * @return array|null
     */
    public function insertMany(array $data): ?array
    {
        $table = $this->getEntityTable();

        $preparedColumns = implode(',', array_keys($data[0]));

        $allValues = [];
        $preparedPlaceholders = [];
        foreach ($data as $index => $row) {
            $row = array_map(function ($item) {
                if (is_bool($item)) {
                    return $item ? 1 : 0;
                }
                return $item;
            }, $row);

            $placeholders = [];
            foreach ($row as $column => $value) {
                $placeholder = ":$column$index";
                $placeholders[] = $placeholder;
                $allValues[$placeholder] = $value;
            }
            $preparedPlaceholders[] = '(' . implode(',', $placeholders) . ')';
        }

        $allPlaceholders = implode(',', $preparedPlaceholders);
        $query = "INSERT INTO $table ($preparedColumns) VALUES $allPlaceholders RETURNING id;";

        try {
            $this->transaction();
            $statement = $this->getPreparedStatement($query);
            $success = $statement->execute($allValues);

            if (! $success) {
                return null;
            }

            $lastIds = $statement->fetchAll(PDO::FETCH_COLUMN, 0);
            $this->commit();

            return $this->whereIn($lastIds);
        } catch (Throwable $e) {
            $this->rollback();

            ErrorHandler::handleExceptions($e);
        }
    }

    /**
     * @param int $id
     * @param array $data
     * @return Entity|null
     */
    public function update(int $id, array $data): ?Entity
    {
        $data = array_map(function ($item) {
            if (is_bool($item)) {
                return $item ? 1 : 0;
            }
            return $item;
        }, $data);

        $data['id'] = $id;
        $table = $this->getEntityTable();
        $columns = $this->getPreparedColumns($data);
        $query = "UPDATE $table SET $columns WHERE id = :id";

        try {
            $this->transaction();
            $statement = $this->getPreparedStatement($query);
            $statement->execute($data);
            $this->commit();

            return $this->findById($id);
        } catch (Throwable $e) {
            $this->rollback();

            ErrorHandler::handleExceptions($e);
        }
    }

    /**
     * @param int $id
     * @return bool
     */
    public function delete(int $id): bool
    {
        $table = $this->getEntityTable();
        $query = "DELETE FROM $table WHERE id = :id;";

        try {
            $this->transaction();
            $statement = $this->getPreparedStatement($query);
            $success = $statement->execute(['id' => $id]);
            $this->commit();

            return $success;
        } catch (Throwable $e) {
            $this->rollback();

            ErrorHandler::handleExceptions($e);
        }
    }

    /**
     * @param string $query
     * @param array $params
     * @return string
     */
    private function addParametersToQuery(string $query, array $params): string
    {
        if (! empty($params)) {
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