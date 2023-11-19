<?php

declare(strict_types=1);

namespace App\Core\Helpers;

use App\Core\App;

/**
 * Class Config
 *
 * @package App\Core\Helpers
 */
class Config
{
    /**
     * @param string $key
     * @param bool|string|array|null $default
     * @return array|bool|string|null
     */
    public static function get(string $key, bool|string|array|null $default = null): string|array|bool|null
    {
        if (self::runTimeConfig($key)) {
            return self::runTimeConfig($key);
        }

        $keyNameParts = explode('.', $key);
        $configFileName = array_shift($keyNameParts) . '.php';
        $key = implode('.', $keyNameParts);
        $config = require App::instance()->configPath() . $configFileName;

        return Arr::get($key, $config) ?? $default;
    }

    /**
     * @param string $key
     * @param bool|string|array|null $value
     * @return string|array|bool|null
     */
    public static function set(string $key, bool|string|array|null $value = null): string|array|bool|null
    {
        if (! is_null($value)) {
            self::runTimeConfig($key, $value);
        }

        return $value;
    }

    /**
     * @param string $key
     * @param bool|string|array|null $value
     * @return array|bool|string|null
     */
    private static function runTimeConfig(string $key, bool|string|array|null $value = null): bool|array|string|null
    {
        $key = 'config.' . $key;

        if (is_null($value)) {
            return Arr::get($key, $_REQUEST);
        } else {
            Arr::set($key, $value, $_REQUEST);

            return $value;
        }
    }
}