<?php

declare(strict_types=1);

namespace App\Core\Router\Route;

/**
 * Class CurrentRoute
 *
 * @package App\Core\Router\Route
 */
class CurrentRoute
{
    protected array $parameters;

    /**
     * @param RouteHandler $handler
     * @param UriDefinition $uriDefinition
     * @param array $uriMatches
     * @param string|null $name
     * @param array|null $middleware
     */
    public function __construct(
        protected RouteHandler $handler,
        protected UriDefinition $uriDefinition,
        protected array $uriMatches,
        protected ?string $name = null,
        protected ?array $middleware = [],
    ) {
        $this->parameters =
            $this->getUriParameters(
                $uriMatches,
                $uriDefinition->getParametersDefinitions()
            );
    }

    /**
     * @param array $route
     * @return CurrentRoute
     */
    public static function fromArray(array $route): CurrentRoute
    {
        return new static(
            handler: $route['handler'] ?? null,
            uriDefinition: $route['uriDefinition'] ?? null,
            uriMatches: $route['uriMatches'] ?? null,
            name: $route['name'] ?? null,
            middleware: $route['middleware'] ?? null,
        );
    }

    /**
     * @param array $uriMatches
     * @param array $uriParametersDefinition
     * @return array
     */
    private function getUriParameters(array $uriMatches, array $uriParametersDefinition): array
    {
        $params = [];
        /** @var UriParameterDefinition $definition */
        foreach ($uriParametersDefinition as $definition) {
            $name = $definition->getName();
            $params[$name] = ($definition->getType() === 'string')
                ? $uriMatches[$name]
                : (int)$uriMatches[$name];
        }

        return $params;
    }

    /**
     * @return RouteHandler
     */
    public function getHandler(): RouteHandler
    {
        return $this->handler;
    }

    /**
     * @return array
     */
    public function getParameters(): array
    {
        return $this->parameters;
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
}