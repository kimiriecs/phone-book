<?php

declare(strict_types=1);

namespace App\Core\Database;

use App\Core\ErrorHandler\ErrorHandler;
use App\Core\Helpers\Config;
use PDO;
use PDOException;

/**
 * Class DB
 *
 * @package App\Core\Database
 */
class DB
{
    /**
     * @var string|null $connectionName
     */
    private ?string $connectionName = null;

    /**
     * @var PDO|null $connection
     */
    private ?PDO $connection = null;

    /**
     * @param string|null $connectionName
     * @return PDO|null
     */
    public function connect(?string $connectionName = null): ?PDO
    {
        if (is_null($this->connection)) {
            $this->setConnection($connectionName);
        }

        if ($this->connectionName !== $connectionName) {
            $this->disconnect();
            $this->setConnection($connectionName);
        }

        return $this->connection;
    }

    /**
     * @param string|null $connectionName
     * @return void
     */
    private function setConnection(?string $connectionName = null): void
    {
        if (is_null($connectionName)) {
            $this->connectionName = Config::get('database.default');
        } else {
            $this->connectionName = Config::get("database.$connectionName");
        }

        $connectionParameters = Config::get("database.connection." . $this->connectionName);

        try {
            $driver = $connectionParameters['driver'];
            $host = $connectionParameters['host'];
            $port = $connectionParameters['port'];
            $dbname = $connectionParameters['database'];
            $username = $connectionParameters['user_name'];
            $password = $connectionParameters['password'];
            $dsn = "$driver:host=$host;port=$port;dbname=$dbname;";

            $attributes = [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
                PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
                PDO::ATTR_AUTOCOMMIT => FALSE
            ];

            $this->connection = new PDO($dsn, $username, $password, $attributes);
        } catch (PDOException $e) {
            ErrorHandler::handleExceptions($e);
        }
    }

    /**
     * @return void
     */
    public function disconnect(): void
    {
        $this->connection = null;
        $this->connectionName = null;
    }

    /**
     * @return PDO|null
     */
    public function connection(): ?PDO
    {
        return $this->connection;
    }
}