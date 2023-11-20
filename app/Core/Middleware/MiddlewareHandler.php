<?php

declare(strict_types=1);

namespace App\Core\Middleware;

use App\Core\App;
use App\Core\ErrorHandler\ErrorHandler;
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
     * @var array|string[] $middleware
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
     * @return mixed|void
     */
    public function handle(Request $request)
    {
        $this->loadMiddleware();

        try {
            if (! empty($this->middleware)) {
                $middlewareClass = array_shift($this->middleware);
                $middleware = App::instance()->get($middlewareClass);

                if ($middleware instanceof Middleware) {
                    return $middleware->handle($request, function ($request) {
                        return $this->handle($request);
                    });
                }
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