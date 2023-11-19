<?php

declare(strict_types=1);

namespace App\Core\Session;

use App\Core\Helpers\Arr;
use App\Core\Helpers\Config;
use Exception;

/**
 * Class Session
 *
 * @package App\Core\Session
 */
class Session
{
    private const SESSION_LIFETIME_MINUTE_TO_SECONDS_MULTIPLIER = 60;
    public const SESSION_CSRF_TOKEN_KEY = 'csrf_token';

    /**
     * @return void
     */
    public static function start(): void
    {
        if (session_status() !== PHP_SESSION_ACTIVE) {
            self::setConfiguration();
            session_start();
        }
    }

    /**
     * @return void
     */
    private static function setConfiguration(): void
    {
        $config = Config::get('session');

        ini_set('session.use_cookies', $config['use_cookie']);
        ini_set('session.use_only_cookies', $config['use_only_cookie']);
        session_name($config['session_name']);

        session_set_cookie_params([
            'lifetime' => self::getLifeTimeInSeconds($config['life_time']),
            'path' => $config['path'],
            'domain' => $config['domain'],
            'secure' => $config['secure'],
            'httponly' => $config['http_only'],
            'samesite' => $config['same_site'],
        ]);
    }

    /**
     * @return void
     * @throws Exception
     */
    public static function setCsrf(): void
    {
        self::set(self::SESSION_CSRF_TOKEN_KEY, bin2hex(random_bytes(32)));
    }

    /**
     * @return string|null
     */
    public static function getCsrf(): ?string
    {
        return self::get(self::SESSION_CSRF_TOKEN_KEY);
    }

    /**
     * @param string $csrf
     * @return bool
     */
    public static function checkCsrf(string $csrf): bool
    {
        return self::getCsrf() === $csrf;
    }

    /**
     * @return mixed
     */
    public static function all(): array
    {
        return $_SESSION;
    }

    /**
     * @param string $key
     * @return mixed
     */
    public static function get(string $key): mixed
    {
        return Arr::get($key, $_SESSION);
    }

    /**
     * @param string $key
     * @return bool
     */
    public static function has(string $key): bool
    {
        return Arr::exists($key, $_SESSION);
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return void
     */
    public static function set(string $key, mixed $value): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            Arr::set($key, $value, $_SESSION);
        }
    }

    /**
     * @param string $key
     * @return void
     */
    public static function unset(string $key): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            Arr::unset($key, $_SESSION);
        }
    }

    /**
     * @param string $key
     * @param mixed $value
     * @return void
     * @throws Exception
     */
    public static function add(string $key, mixed $value): void
    {
        if (session_status() === PHP_SESSION_ACTIVE) {
            Arr::add($key, $value, $_SESSION);
        }
    }

    /**
     * @param int $lifeTimeMinutes
     * @return int
     */
    private static function getLifeTimeInSeconds(int $lifeTimeMinutes): int
    {
        $seconds = $lifeTimeMinutes * self::SESSION_LIFETIME_MINUTE_TO_SECONDS_MULTIPLIER;

        return (int) $seconds;
    }
}