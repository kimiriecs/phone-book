<?php

declare(strict_types=1);

namespace App\Core;

use App\Core\Container\Container;
use App\Core\Database\DB;
use App\Core\Env\Env;
use App\Core\ErrorHandler\ErrorHandler;
use App\Core\Logger\Log;
use App\Core\Middleware\MiddlewareHandler;
use App\Core\Middleware\MiddlewareRegister;
use App\Core\Request\Request;
use App\Core\Request\Validation\ErrorBag;
use App\Core\Response\Response;
use App\Core\Router\Router;
use App\Core\ServiceProvider\ServiceProvider;
use App\Core\Session\Session;
use Throwable;

/**
 * Class App
 *
 * @package App\Core
 */
class App extends Container
{
    private const CONFIG_PATH = 'config';

    /**
     * @var string $basePath
     */
    private static string $basePath;

    /**
     * @var Env $env
     */
    private static Env $env;

    /**
     * @param string $basePath
     * @return App
     */
    public static function start(string $basePath): App
    {
        $app = self::instance();
        $app->setBasePath($basePath);
        $app->setEnvironment($basePath);
        $app->configureErrorHandling();
        $app->run();

        return $app;
    }

    /**
     * @param string $basePath
     * @return void
     */
    private function setBasePath(string $basePath): void
    {
        self::$basePath = $basePath;
    }

    /**
     * @param string $basePath
     * @return void
     */
    private function setEnvironment(string $basePath): void
    {
        self::$env = new Env($basePath);
    }

    /**
     * @return void
     */
    private function configureErrorHandling(): void
    {
        if (self::env()->getBoolean('APP_DEBUG') === true) {
            // Debug is enabled. Show all errors
            error_reporting(E_ALL);
            ini_set('display_errors', 1);
        } else {
            // Debug is disabled. Don't show any errors
            error_reporting(0);
            ini_set('display_errors', 0);
        }

        set_error_handler([ErrorHandler::class, 'handleErrors']);
        set_exception_handler([ErrorHandler::class, 'handleExceptions']);
    }

    /**
     * @return void
     */
    private function run(): void
    {
        try {
            $this->initialize();

            if (PHP_SAPI !== 'cli') {
                $this->router()->dispatch();
            }

            $this->db()->connect();
        } catch (Throwable $e) {
            ErrorHandler::handleExceptions($e);
        }
    }

    /**
     * @return void
     */
    private function initialize(): void
    {
        try {
            $this->singleton(Log::class);

            $this->singleton(ServiceProvider::class);
            $this->serviceProvider()->register();
            $this->serviceProvider()->registerCommands();

            if (PHP_SAPI !== 'cli') {
                $this->singleton(Session::class);
                $this->singleton(Request::class);
                $this->singleton(Response::class);
                $this->singleton(MiddlewareRegister::class);
                $this->singleton(MiddlewareHandler::class);
                $this->singleton(Router::class);
                $this->singleton(ErrorBag::class);
            }

            $this->singleton(DB::class);
        } catch (Throwable $e) {
            ErrorHandler::handleExceptions($e);
        }
    }

    /**
     * @return string
     */
    public static function basePath(): string
    {
        return self::$basePath;
    }

    /**
     * @return Env
     */
    public static function env(): Env
    {
        return self::$env;
    }

    /**
     * @return string
     */
    public static function configPath(): string
    {
        return self::basePath() . '/' . self::CONFIG_PATH . '/';
    }

    /**
     * @param string $className
     * @param array|null $boundParameters
     * @return mixed
     */
    public function make(string $className, ?array $boundParameters = []): mixed
    {
        try {
            return self::instance()->get($className, $boundParameters);
        } catch (Throwable $e) {
            ErrorHandler::handleExceptions($e);
        }
    }

    /**
     * @return Log
     */
    public static function log(): Log
    {
        return self::instance()->make(Log::class);
    }

    /**
     * @return ServiceProvider
     */
    private function serviceProvider(): ServiceProvider
    {
        return self::instance()->make(ServiceProvider::class);
    }

    /**
     * @return Session
     */
    public static function session(): Session
    {
        return self::instance()->make(Session::class);
    }

    /**
     * @return Request
     */
    public static function request(): Request
    {
        return self::instance()->make(Request::class);
    }

    /**
     * @return Response
     */
    public static function response(): Response
    {
        return self::instance()->make(Response::class);
    }

    /**
     * @return ErrorBag
     */
    public static function errorBag(): ErrorBag
    {
        return self::instance()->make(ErrorBag::class);
    }

    /**
     * @return Router
     */
    public static function router(): Router
    {
        return self::instance()->make(Router::class);
    }

    /**
     * @return DB
     */
    public static function db(): DB
    {
        return self::instance()->make(DB::class);
    }
}