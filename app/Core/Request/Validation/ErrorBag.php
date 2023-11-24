<?php

declare(strict_types=1);

namespace App\Core\Request\Validation;

use App\Core\App;
use Exception;

/**
 * Class ErrorBag
 *
 * @package App\Core\Request\Validation
 */
class ErrorBag
{
    public const SESSION_ERROR_BAG_KEY = 'error_bag';
    public const SESSION_OLD_INPUT_KEY = 'old_input';


    /**
     * @param string|null $key
     * @return array|mixed
     */
    public function get(?string $key = null): mixed
    {
        $fullKey = self::SESSION_ERROR_BAG_KEY . '.' . $key;

        return App::session()->get($fullKey) ?? [];
    }

    /**
     * @return array
     */
    public function all(): array
    {
        return App::session()->get(self::SESSION_ERROR_BAG_KEY) ?? [];
    }

    /**
     * @param $key
     * @return bool
     */
    public function exists($key): bool
    {
        $fullKey = $key ? self::SESSION_OLD_INPUT_KEY . '.' . $key : self::SESSION_OLD_INPUT_KEY;

        return App::session()->has($fullKey);
    }

    /**
     * @return bool
     */
    public function hasErrors(): bool
    {
        return !empty($this->all());
    }

    /**
     * @param string $key
     * @param string $message
     * @return void
     * @throws Exception
     */
    public function add(string $key, string $message): void
    {
        $fullKey = self::SESSION_ERROR_BAG_KEY . '.' . $key;

        if (! $this->get($key) || ! in_array($message, $this->get($key))) {
            App::session()->add($fullKey, $message);
        }
    }

    /**
     * @param string|null $key
     * @return mixed
     */
    public function getOld(?string $key = null): mixed
    {
        $fullKey = $key ? self::SESSION_OLD_INPUT_KEY . '.' . $key : self::SESSION_OLD_INPUT_KEY;

        return $key ? App::session()->get($fullKey) : (App::session()->get($fullKey) ?? []);
    }

    /**
     * @param string $field
     * @param mixed $value
     * @return void
     */
    public function addOld(string $field, mixed $value): void
    {
        $fullKey = self::SESSION_OLD_INPUT_KEY . '.' . $field;

        if (! $this->get($field)) {
            App::session()->set($fullKey, $value);
        }
    }

    /**
     * @param string $field
     * @param mixed $value
     * @return void
     */
    public function setOld(string $field, mixed $value): void
    {
        $fullKey = self::SESSION_OLD_INPUT_KEY . '.' . $field;
        App::session()->set($fullKey, $value);
    }

    /**
     * @return void
     */
    public function cleanErrors(): void
    {
        App::session()->set(self::SESSION_ERROR_BAG_KEY, []);
    }

    /**
     * @return void
     */
    public function cleanOld(): void
    {
        App::session()->set(self::SESSION_OLD_INPUT_KEY, []);
    }

    /**
     * @return void
     */
    public function cleanAll(): void
    {
        App::session()->set(self::SESSION_ERROR_BAG_KEY, []);
        App::session()->set(self::SESSION_OLD_INPUT_KEY, []);
    }
}