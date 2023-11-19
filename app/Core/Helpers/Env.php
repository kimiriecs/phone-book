<?php

declare(strict_types=1);

namespace App\Core\Helpers;

use Dotenv\Dotenv;

/**
 * Class Env
 *
 * @package App\Core\Helpers
 */
class Env
{
    /**
     * @var Dotenv|null $dotenv
     */
    private static ?Dotenv $dotenv = null;

    /**
     * @return void
     */
    private static function load(): void
    {
        if (!self::$dotenv) {
            self::$dotenv = Dotenv::createImmutable(Path::basePath());
            self::$dotenv->safeLoad();
        }
    }

    /**
     * @param string $key
     * @param bool|int|string|null $default
     * @return mixed
     */
    public static function get(string $key, bool|int|string|null $default = null): mixed
    {
        self::load();

        return $_ENV[$key] ?? $default;
    }

    /**
     * @param string $key
     * @param bool|string|null $default
     * @return bool|null
     */
    public static function getBoolean(string $key, bool|string|null $default = null): bool|null
    {
        return filter_var(self::get($key, $default), FILTER_VALIDATE_BOOLEAN);
    }

    /**
     * @param string $key
     * @param int|string|null $default
     * @return int|null
     */
    public static function getInt(string $key, int|string|null $default = null): int|null
    {
        return filter_var(self::get($key, $default), FILTER_VALIDATE_INT);
    }
}