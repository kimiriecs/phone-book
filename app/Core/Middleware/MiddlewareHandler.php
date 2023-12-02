<?php

declare(strict_types=1);

namespace App\Core\Middleware;

use App\Core\App;
use App\Core\ErrorHandler\ErrorHandler;
use App\Core\Exceptions\InvalidClassException;
use App\Core\Request\Request;
use Throwable;

/**
 * Class MiddlewareHandler
 *
 * @package App\Core\Middleware
 */
class MiddlewareHandler
{
    /**
     * @var string[] $middleware
     */
    protected array $middleware;

    /**
     * @param MiddlewareRegister $register
     */
    public function __construct(
        protected MiddlewareRegister $register
    ) {
    }

    /**
     * @param Request $request
     * @return void
     */
    public function handle(Request $request): void
    {
        $this->loadMiddleware();

        $this->runMiddleware($request);
    }

    /**
     * @param Request $request
     * @return mixed|void
     */
    public function runMiddleware(Request $request)
    {
        try {
            if (! empty($this->middleware)) {
                $middlewareClass = array_shift($this->middleware);
                $middleware = App::instance()->make($middlewareClass);

                if (! $middleware instanceof Middleware) {
                    throw new InvalidClassException("Invalid middleware class: $middlewareClass is not an instance of " . Middleware::class);
                }

                return $middleware->handle($request, function ($request) {
                    return $this->runMiddleware($request);
                });
            }
        } catch (Throwable $e) {
            ErrorHandler::handleExceptions($e);
        }
    }

    /**
     * @return void
     */
    private function loadMiddleware(): void
    {
        $this->middleware = $this->register->getMiddleware();
    }
}