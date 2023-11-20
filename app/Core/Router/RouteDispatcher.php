<?php

declare(strict_types=1);

namespace App\Core\Router;

use App\Core\App;
use App\Core\ErrorHandler\ErrorHandler;
use App\Core\Middleware\MiddlewareHandler;
use App\Core\Middleware\MiddlewareRegister;
use App\Core\Request\Request;
use App\Core\Router\Route\CurrentRoute;
use Throwable;

/**
 * Class RouteDispatcher
 *
 * @package App\Core\Router
 */
class RouteDispatcher
{
    /**
     * @param Request $request
     * @param MiddlewareRegister $middlewareRegister
     * @param MiddlewareHandler $middlewareHandler
     */
    public function __construct(
        protected Request $request,
        protected MiddlewareRegister $middlewareRegister,
        protected MiddlewareHandler $middlewareHandler,
    ) {
    }

    /**
     * @param CurrentRoute $route
     * @return void
     */
    public function handle(CurrentRoute $route): void
    {
        try {
            $this->middlewareRegister->addWebMiddleware($route->getMiddleware());
            $this->middlewareHandler->handle($this->request);

            $parameters = $route->getParameters();
            $handler = $route->getHandler();

            App::instance()->call($handler->getController(), $handler->getAction(), $parameters);
        } catch (Throwable $e) {
            ErrorHandler::handleExceptions($e);
        }
    }
}