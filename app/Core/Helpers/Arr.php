<?php declare(strict_types=1);

namespace App\Core\Helpers;

use Exception;

/**
 * Class Arr
 *
 * @package App\Core\Helpers
 */
class Arr
{
    /**
     * @param string $key
     * @param array $array
     * @return mixed
     */
    public static function get(string $key, array $array): mixed
    {
        if (trim($key) === '') {
            return $array;
        }

        $keys = explode('.', $key);
        foreach ($keys as $k) {
            if (!isset($array[$k])) {
                return null;
            }

            $array = $array[$k];
        }

        return $array;
    }

    /**
     * @param string $key
     * @param array $array
     * @return bool
     */
    public static function exists(string $key, array $array): bool
    {
        if (trim($key) === '') {
            return false;
        }

        $keys = explode('.', $key);
        foreach ($keys as $k) {
            if (! array_key_exists($k, $array)) {
                return false;
            }

            $array = $array[$k];
        }

        return true;
    }

    /**
     * @param string $key
     * @param array $array
     * @param mixed $value
     * @return void
     * @throws Exception
     */
    public static function add(string $key, mixed $value, array &$array): void
    {
        if (trim($key) === '') {
            return;
        }

        $keys = explode('.', $key);
        $lastKey = array_pop($keys);
        $nestedArray = &self::accessNestedKey($keys, $array);
        if (!isset($nestedArray[$lastKey])) {
            $nestedArray[$lastKey] = [];
        }

        if (!is_array($nestedArray[$lastKey])) {
            throw new Exception("Can not add item: key '$key' is not an array");
        }

        $nestedArray[$lastKey][] = $value;
    }

    /**
     * @param string $key
     * @param array $array
     * @param mixed $value
     * @return void
     */
    public static function set(string $key, mixed $value, array &$array): void
    {
        if (trim($key) === '') {
            return;
        }

        $keys = explode('.', $key);
        $lastKey = array_pop($keys);
        $nestedArray = &self::accessNestedKey($keys, $array);
        $nestedArray[$lastKey] = $value;
    }

    /**
     * @param string $key
     * @param array $array
     * @return void
     */
    public static function unset(string $key, array &$array): void
    {
        if (trim($key) === '') {
            return;
        }

        $keys = explode('.', $key);
        $lastKey = array_pop($keys);
        $nestedArray = &self::accessNestedKey($keys, $array);
        unset($nestedArray[$lastKey]);
    }

    /**
     * @param array $keys
     * @param array $array
     * @return array|mixed
     */
    private static function &accessNestedKey(array $keys, array &$array): mixed
    {
        foreach ($keys as $k) {
            if (!isset($array[$k]) || !is_array($array[$k])) {
                $array[$k] = [];
            }

            $array = &$array[$k];
        }

        return $array;
    }
}