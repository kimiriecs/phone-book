<?php

declare(strict_types=1);

namespace App\Core\Router\Route;

use App\Core\App;
use App\Core\ErrorHandler\ErrorHandler;
use App\Core\Helpers\Str;
use App\Core\Request\HttpMethodEnum;
use Closure;
use Exception;
use Throwable;

/**
 * Class Route
 *
 * @package App\Core\Router
 */
class Route
{
    /**
     * @var string $method
     */
    protected string $method;

    /**
     * @var UriDefinition $uriDefinition
     */
    protected UriDefinition $uriDefinition;

    /**
     * @var RouteHandler $handler
     */
    protected RouteHandler $handler;

    /**
     * @var string|null $name
     */
    protected ?string $name = null;

    /**
     * @var array $middleware
     */
    protected array $middleware = [];

    /**
     * @param string $uriMask
     * @param string $method
     * @param array|Closure $handler
     */
    public function __construct(
        string $uriMask,
        string $method,
        array|Closure $handler
    ) {
        $this->uriDefinition = UriDefinition::fromMask($uriMask);
        $this->method = $method;
        $this->handler = RouteHandler::make($handler);
    }

    /**
     * @param string $uriMask
     * @param array|Closure $handler
     * @return Route
     */
    public static function get(string $uriMask, array|Closure $handler): Route
    {
        return self::make($uriMask, $handler, HttpMethodEnum::GET->value);
    }

    /**
     * @param string $uriMask
     * @param array|Closure $handler
     * @return Route
     */
    public static function post(string $uriMask, array|Closure $handler): Route
    {
        return self::make($uriMask, $handler, HttpMethodEnum::POST->value);
    }

    /**
     * @param string $uriMask
     * @param array|Closure $handler
     * @return Route
     */
    public static function put(string $uriMask, array|Closure $handler): Route
    {
        return self::make($uriMask, $handler, HttpMethodEnum::PUT->value);
    }

    /**
     * @param string $uriMask
     * @param array|Closure $handler
     * @return Route
     */
    public static function patch(string $uriMask, array|Closure $handler): Route
    {
        return self::make($uriMask, $handler, HttpMethodEnum::PATCH->value);
    }

    /**
     * @param string $uriMask
     * @param array|Closure $handler
     * @return Route
     */
    public static function delete(string $uriMask, array|Closure $handler): Route
    {
        return self::make($uriMask, $handler, HttpMethodEnum::DELETE->value);
    }

    /**
     * @param string $uriMask
     * @param array|Closure $handler
     * @param string $method
     * @return Route
     */
    private static function make(string $uriMask, array|Closure $handler, string $method): Route
    {
        $route = new static(
            uriMask: $uriMask,
            method: $method,
            handler: $handler
        );

        try {
            App::router()->register($route);
        } catch (Throwable $e) {
            ErrorHandler::handleExceptions($e);
        }

        return $route;
    }

    /**
     * @return string
     */
    public function getUriMask(): string
    {
        return $this->getUriDefinition()->getUriMask();
    }

    /**
     * @return UriDefinition
     */
    public function getUriDefinition(): UriDefinition
    {
        return $this->uriDefinition;
    }

    /**
     * @return string
     */
    public function getMethod(): string
    {
        return $this->method;
    }

    /**
     * @return RouteHandler
     */
    public function getHandler(): RouteHandler
    {
        return $this->handler;
    }

    /**
     * @return string|null
     */
    public function getName(): ?string
    {
        return $this->name;
    }

    /**
     * @return array
     */
    public function getMiddleware(): array
    {
        return $this->middleware;
    }

    /**
     * @param array|null $args
     * @return string
     */
    public function generateUri(?array $args = []): string
    {
        if (!empty($args)) {
            $args = $this->prepareKeys($args);
            $parametersDefinitions = $this->getUriDefinition()->getParametersDefinitions();

            $patterns = array_map(function (UriParameterDefinition $parameter) {
                return $parameter->getPlaceholderPattern();
            }, $parametersDefinitions);

            $replacements = array_map(function (UriParameterDefinition $parameter) use ($args) {
                return $args[$parameter->getName()];
            }, $parametersDefinitions);

            return preg_replace($patterns, $replacements, $this->getUriMask());
        }

        return $this->getUriMask();
    }

    /**
     * @param array $data
     * @return array
     */
    private function prepareKeys(array $data): array
    {
        $resultData = [];
        foreach ($data as $key => $value) {
            $key = Str::camel($key);

            $resultData[$key] = $value;
        }

        return $resultData;
    }

    /**
     * @param string $name
     * @return Route
     */
    public function name(string $name): Route
    {
        try {
            foreach (App::router()->routes() as $routesByMethod) {
                $routes = array_filter($routesByMethod, function (Route $route) use ($name) {
                    return $route->getName() === $name;
                });

                if (!empty($routes)) {
                    throw new Exception("Route with provided name already exists");
                }
            }

            $this->name = $name;

            return $this;
        } catch (Throwable $e) {
            ErrorHandler::handleExceptions($e);
        }
    }

    /**
     * @param array|string $middleware
     * @return Route
     */
    public function middleware(array|string $middleware): Route
    {
        if (is_array($middleware)) {
            foreach ($middleware as $item) {
                if (!in_array($item, $this->middleware)) {
                    $this->middleware[] = $item;
                }
            }
        }

        if (!in_array($middleware, $this->middleware)) {
            $this->middleware[] = $middleware;
        }

        return $this;
    }
}