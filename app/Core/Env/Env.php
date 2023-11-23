<?php

declare(strict_types=1);

namespace App\Core\Env;

use Dotenv\Dotenv;

/**
 * Class Env
 *
 * @package App\Core\Env
 */
class Env
{
    /**
     * @var Dotenv|null $env
     */
    private ?Dotenv $env = null;

    /**
     * @param string $basePath
     */
    public function __construct(
        string $basePath
    ) {
        $this->load($basePath);
    }

    /**
     * @param string $basePath
     * @return void
     */
    private function load(string $basePath): void
    {
        if (!$this->env) {
            $this->env = Dotenv::createImmutable($basePath);
            $this->env->safeLoad();
        }
    }

    /**
     * @param string $key
     * @param bool|int|string|null $default
     * @return mixed
     */
    public function get(string $key, bool|int|string|null $default = null): mixed
    {
        return $_ENV[$key] ?? $default;
    }

    /**
     * @param string $key
     * @param bool|string|null $default
     * @return bool|null
     */
    public function getBoolean(string $key, bool|string|null $default = null): bool|null
    {
        return filter_var($this->get($key, $default), FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * @param string $key
     * @param int|string|null $default
     * @return int|null
     */
    public function getInt(string $key, int|string|null $default = null): int|null
    {
        return filter_var($this->get($key, $default), FILTER_VALIDATE_INT);
    }
}