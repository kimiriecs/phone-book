<?php declare(strict_types=1);

namespace App\Core\Router\Route;

use Closure;

/**
 * Class RouteHandler
 *
 * @package App\Core\Router\Route
 */
class RouteHandler
{
    const ROUTE_HANDLER_CONTROLLER_INDEX = 0;
    const ROUTE_HANDLER_ACTION_INDEX = 1;
    const ROUTE_HANDLER_DEFAULT_ACTION = '__invoke';

    /**
     * @var string|Closure $controller
     */
    protected string|Closure $controller;

    /**
     * @var string|null $action
     */
    protected ?string $action;

    /**
     * @param array|Closure $handler
     */
    public function __construct(
        array|Closure $handler
    ) {
        $this->controller = is_array($handler)
            ? $handler[self::ROUTE_HANDLER_CONTROLLER_INDEX]
            : $handler;
        $this->action = is_array($handler)
            ? $handler[self::ROUTE_HANDLER_ACTION_INDEX] ?? self::ROUTE_HANDLER_DEFAULT_ACTION
            : null;
    }

    /**
     * @param array|Closure $handler
     * @return RouteHandler
     */
    public static function make(array|Closure $handler): RouteHandler
    {
        return new static(
            handler: $handler
        );
    }

    /**
     * @return string|Closure
     */
    public function getController(): string|Closure
    {
        return $this->controller;
    }

    /**
     * @return string|null
     */
    public function getAction(): ?string
    {
        return $this->action;
    }
}