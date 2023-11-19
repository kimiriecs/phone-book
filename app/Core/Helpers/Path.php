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
    public static function basePath(?string $path = ''): string
    {
        $path = trim($path, ' \/');

        return $path === ''
            ? App::instance()->basePath()
            : App::instance()->basePath() . '/' . $path;
    }

    /**
     * @param string $path
     * @return string
     */
    public static function routesPath(string $path): string
    {
        return Config::get('app.paths.routes') . $path . '.php';
    }

    /**
     * @param string $path
     * @return string
     */
    public static function viewsPath(string $path): string
    {
        return Config::get('app.paths.views') . $path . View::TEMPLATE_FILE_EXTENSION;
    }

    /**
     * @param string $path
     * @return string
     */
    public static function logsPath(string $path): string
    {
        return Config::get('app.paths.logs') . $path . '.log';
    }
}