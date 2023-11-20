<?php

declare(strict_types=1);

namespace App\Core;

use App\Core\Container\Container;
use App\Core\ErrorHandler\ErrorHandler;
use App\Core\Helpers\Env;
use App\Core\Logger\Log;
use App\Core\Middleware\MiddlewareHandler;
use App\Core\Middleware\MiddlewareRegister;
use App\Core\Request\Request;
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
    protected string $basePath;

    /**
     * App Constructor
     */
    protected function __construct()
    {
        parent::__construct();

        $this->configureErrorHandling();
    }

    /**
     * @param string $basePath
     * @return void
     */
    public function run(string $basePath): void
    {
        try {
            $this->initialize($basePath);
            $this->serviceProvider()->register();
        } catch (Throwable $e) {
            ErrorHandler::handleExceptions($e);
        }
    }

    /**
     * @param string $basePath
     * @return void
     */
    private function initialize(string $basePath): void
    {
        try {
            $this->setBasePath($basePath);
            $this->configureErrorHandling();
            $this->singleton(Log::class);
            $this->singleton(ServiceProvider::class);
            $this->singleton(Session::class);
            $this->singleton(Request::class);
            $this->singleton(MiddlewareRegister::class);
            $this->singleton(MiddlewareHandler::class);
        } catch (Throwable $e) {
            ErrorHandler::handleExceptions($e);
        }
    }

    /**
     * @param string $basePath
     * @return void
     */
    public function setBasePath(string $basePath): void
    {
        $this->basePath = $basePath;
    }

    /**
     * @return void
     */
    private function configureErrorHandling(): void
    {
        if (Env::getBoolean('APP_DEBUG') === true) {
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
     * @return string
     */
    public function basePath(): string
    {
        return $this->basePath;
    }

    /**
     * @return string
     */
    public function configPath(): string
    {
        return $this->basePath . '/' . self::CONFIG_PATH . '/';
    }

    /**
     * @param string $className
     * @return mixed
     */
    public function make(string $className): mixed
    {
        try {
            return self::instance()->get($className);
        } catch (Throwable $e) {
            ErrorHandler::handleExceptions($e);
        }
    }

    /**
     * @return Log
     */
    public function log(): Log
    {
        return $this->make(Log::class);
    }

    /**
     * @return ServiceProvider
     */
    private function serviceProvider(): ServiceProvider
    {
        return $this->make(ServiceProvider::class);
    }

    /**
     * @return Session
     */
    public function session(): Session
    {
        return $this->make(Session::class);
    }

    /**
     * @return Request
     */
    public function request(): Request
    {
        return $this->make(Request::class);
    }
}