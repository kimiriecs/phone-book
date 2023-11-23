<?php

declare(strict_types=1);

namespace App\Core\Helpers;

use App\Core\App;
use App\Core\View\View;

/**
 * Class Path
 *
 * @package App\Core\Helpers
 */
class Path
{
    /**
     * @param string|null $path
     * @return string
     */
    public static function base(?string $path = ''): string
    {
        $path = trim($path, ' \/');

        return $path === ''
            ? App::basePath()
            : App::basePath() . '/' . $path;
    }

    /**
     * @param string $path
     * @return string
     */
    public static function routes(string $path): string
    {
        return Config::get('app.paths.routes') . $path . '.php';
    }

    /**
     * @param string $path
     * @return string
     */
    public static function views(string $path): string
    {
        return Config::get('app.paths.views') . $path . View::TEMPLATE_FILE_EXTENSION;
    }

    /**
     * @param string $path
     * @return string
     */
    public static function logs(string $path): string
    {
        return Config::get('app.paths.logs') . $path . '.log';
    }

    /**
     * @param string $path
     * @return string
     */
    public static function database(string $path): string
    {
        return Config::get('app.paths.database') . $path . '.php';
    }

    /**
     * @param string $path
     * @return string
     */
    public static function migrations(string $path): string
    {
        return Config::get('app.paths.migrations') . $path . '.php';
    }

    /**
     * @param string $path
     * @return string
     */
    public static function seeders(string $path): string
    {
        return Config::get('app.paths.seeders') . $path . '.php';
    }
}