<?php

declare(strict_types=1);

namespace App\Core\Router;

use App\Core\App;
use App\Core\ErrorHandler\ErrorHandler;
use App\Core\Helpers\Path;
use App\Core\Request\Request;
use App\Core\Router\Route\CurrentRoute;
use App\Core\Router\Route\Route;
use App\Core\Router\Route\UriDefinition;
use Exception;
use Throwable;

/**
 * Class Router
 *
 * @package App\Core\Router
 */
class Router
{
    /**
     * @var array $routes
     */
    protected array $routes = [];

    /**
     * @param Request $request
     * @param RouteDispatcher $dispatcher
     */
    public function __construct(
        protected Request $request,
        protected RouteDispatcher $dispatcher
    ) {
    }

    /**
     * @param Route $route
     * @return void
     */
    public function register(Route $route): void
    {
        try {
            if (isset($this->routes[$route->getMethod()])
                && key_exists($route->getUriMask(), $this->routes[$route->getMethod()])
            ) {
                throw new Exception(
                    "Duplicate route declaration for "
                    . "route '{$route->getUriMask()}' "
                    . "with method '{$route->getMethod()}'");
            }

            $this->routes[$route->getMethod()][$route->getUriMask()] = $route;
        } catch (Throwable $e) {
            ErrorHandler::handleExceptions($e);
        }
    }

    /**
     * @return array
     */
    public function routes(): array
    {
        return $this->routes;
    }

    /**
     * @return void
     */
    public function dispatch(): void
    {
        try {
            $this->loadRoutes();

            $route = $this->getCurrentRoute($this->request->uri(), $this->request->method());

            if (! $route instanceof CurrentRoute) {
                App::response()->redirect(App::router()->uri('notFound'));
            } else {
                App::request()->setRoute($route);
                $this->dispatcher->handle($route);
            }
        } catch (Throwable $e) {
            ErrorHandler::handleExceptions($e);
        }
    }

    /**
     * @throws Exception
     */
    private function loadRoutes(): void
    {
        require_once Path::routes('web');
        require_once Path::routes('api');
    }

    /**
     * @param string $uri
     * @param string $method
     * @return CurrentRoute|null
     */
    private function getCurrentRoute(string $uri, string $method): ?CurrentRoute
    {
        $currentRoute = null;
        $routesByMethod = $this->routes[$method] ?? null;

        if (! $routesByMethod) {
            return null;
        }

        /** @var Route $route */
        foreach ($routesByMethod as $route) {
            $uriDefinition = $route->getUriDefinition();

            preg_match(
                $uriDefinition->getFullUriRegex(),
                $uri,
                $uriMatches,
                PREG_UNMATCHED_AS_NULL
            );

            if (isset($uriMatches[UriDefinition::ROUTE_FULL_URI_REGEX_KEY])) {
                $currentRoute = CurrentRoute::fromArray([
                    'handler' => $route->getHandler(),
                    'name' => $route->getName(),
                    'middleware' => $route->getMiddleware(),
                    'uriDefinition' => $uriDefinition,
                    'uriMatches' => $uriMatches,
                ]);

                break;
            }
        }

        return $currentRoute;
    }

    /**
     * @param string $name
     * @param array|null $args
     * @return string
     */
    public function uri(string $name, ?array $args = []): string
    {
        $route = null;

        try {
            foreach ($this->routes() as $routesByMethod) {
                $routes = array_filter($routesByMethod,
                    function (Route $route) use ($name) {
                        return $route->getName() === $name;
                    });

                if (! empty($routes)) {
                    $route = array_shift($routes);
                    break;
                }
            }

            if (! $route instanceof Route) {
                throw new Exception("Route with provided name: '$name' does not exists");
            }

            return $route->generateUri($args);
        } catch (Throwable $e) {
            ErrorHandler::handleExceptions($e);
        }

    }
}