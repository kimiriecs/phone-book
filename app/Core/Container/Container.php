<?php

declare(strict_types=1);

namespace App\Core\Container;

use App\Core\Exceptions\ClassNotFoundException;
use App\Core\Exceptions\ContainerException;
use App\Core\Exceptions\ParameterNotFoundException;
use Closure;
use Exception;
use Psr\Container\ContainerInterface;
use ReflectionClass;
use ReflectionException;
use ReflectionFunction;
use ReflectionMethod;
use ReflectionParameter;

/**
 * Class NewContainer
 *
 * @package App\Core\Container
 */
class Container implements ContainerInterface
{
    protected array $entries = [];
    protected array $singletons = [];
    protected static array $instances = [];

    /**
     * @return void
     */
    protected function __construct()
    {
    }

    /**
     * @return void
     */
    protected function __clone()
    {
    }

    /**
     * @return mixed
     * @throws Exception
     */
    public function __wakeup()
    {
        throw new Exception('Can not unserialize a singleton.');
    }

    /**
     * @return static
     */
    public static function instance(): static
    {
        $instanceClass = static::class;
        if (!isset(self::$instances[$instanceClass])) {
            self::$instances[$instanceClass] = new static();
        }

        return self::$instances[$instanceClass];
    }

    /**
     * @param string $id
     * @param array|null $boundParameters
     * @return mixed
     * @throws ClassNotFoundException
     * @throws ContainerException
     * @throws ParameterNotFoundException
     * @throws ReflectionException
     */
    public function get(string $id, ?array $boundParameters = []): mixed
    {
        if ($this->has($id)) {
            $entry = $this->entries[$id];

            if ($entry instanceof Closure || is_callable($entry)) {
                return $entry($this, $boundParameters);
            }
        }

        return $this->resolve($id, $boundParameters);
    }

    /**
     * @param string $id
     *
     * @return bool
     */
    public function has(string $id): bool
    {
        return isset($this->entries[$id]);
    }

    /**
     * @param string $id
     *
     * @return bool
     */
    public function isSingleton(string $id): bool
    {
        return isset($this->singletons[$id]);
    }

    /**
     * @param string $abstract
     * @param callable|string|null $concrete
     * @return void
     */
    public function bind(string $abstract, callable|string|null $concrete = null): void
    {
        if (is_null($concrete)) {
            $concrete = $abstract;
        }

        $this->entries[$abstract] = $concrete;
    }

    /**
     * @param string $abstract
     * @param string|null $concrete
     * @return mixed
     * @throws ClassNotFoundException
     * @throws ContainerException
     * @throws ParameterNotFoundException
     * @throws ReflectionException
     */
    public function singleton(string $abstract, ?string $concrete = null): mixed
    {
        if (is_null($concrete)) {
            $concrete = $abstract;
        }

        if (!$this->isSingleton($abstract)) {
            $this->singletons[$abstract] = $this->resolve($concrete);
        }

        return $this->singletons[$abstract];
    }

    /**
     * @param string|Closure $callable
     * @param string|null $method
     * @param array|null $boundParameters
     * @return mixed|void
     * @throws ClassNotFoundException
     * @throws ContainerException
     * @throws ParameterNotFoundException
     * @throws ReflectionException
     */
    public function call(string|Closure $callable, ?string $method = null, ?array $boundParameters = [])
    {
        $methodReflector = ($callable instanceof Closure)
            ? new ReflectionFunction($callable)
            : new ReflectionMethod($callable, $method);

        $methodParameters = $this->getArguments($methodReflector, $boundParameters);

        if ($methodReflector->isClosure()) {
            return $methodReflector->invokeArgs($methodParameters);
        }

        $class = $this->get($callable, $boundParameters);

        return $methodReflector->invokeArgs($class, $methodParameters);
    }

    /**
     * @param string $id
     * @param array|null $boundParameters
     * @return mixed|void
     * @throws ClassNotFoundException
     * @throws ContainerException
     * @throws ParameterNotFoundException
     * @throws ReflectionException
     */
    private function resolve(string $id, ?array $boundParameters = [])
    {
        if ($this->isSingleton($id)) {
            return $this->singletons[$id];
        }

        $reflector = $this->getReflector($id);

        if ($reflector->isInterface()) {
            return $this->resolveInterface($reflector);
        }

        if (!$reflector->isInstantiable()) {
            throw new ContainerException(
                "Error: {$reflector->getName()} cannot be instantiated"
            );
        }

        $constructor = $reflector->getConstructor();
        if (!$constructor) {
            return $reflector->newInstance();
        }

        $args = $this->getArguments($constructor, $boundParameters);

        return $reflector->newInstanceArgs($args);
    }

    /**
     * @param ReflectionClass $reflector
     * @return mixed|void
     * @throws ClassNotFoundException
     * @throws ContainerException
     * @throws ParameterNotFoundException
     * @throws ReflectionException
     */
    private function resolveInterface(ReflectionClass $reflector)
    {
        if ($this->has($reflector->getName())) {
            return $this->get(
                $this->entries[$reflector->getName()]
            );
        }

        throw new ClassNotFoundException(
            "Class {$reflector->getName()} not found"
        );
    }


    /**
     * @param string $id
     * @return ReflectionClass
     * @throws ClassNotFoundException
     */
    private function getReflector(string $id): ReflectionClass
    {
        try {
            return (new ReflectionClass($id));
        } catch (ReflectionException $e) {
            throw new ClassNotFoundException(
                $e->getMessage(), $e->getCode()
            );
        }
    }

    /**
     * @param ReflectionMethod|ReflectionFunction $method
     * @param array|null $boundParameters
     * @return array
     * @throws ParameterNotFoundException
     */
    private function getArguments(
        ReflectionMethod|ReflectionFunction $method,
        ?array $boundParameters = []
    ): array {
        $args = [];
        $params = $method->getParameters();
        $calledClass = $method->getClosureCalledClass()?->getName();

        foreach ($params as $param) {
            $name = $param->getName();
            $type = $param->getType();

            $parameter = null;

            if (!$type) {
                $parameter = $this->getBoundParameter($name, $boundParameters);
            }

            if ($type instanceof \ReflectionNamedType) {
                $parameter = $this->getNamedParameter($param, $boundParameters);
            }

            if (is_null($parameter) && $param->isDefaultValueAvailable()) {
                $parameter = $param->getDefaultValue();
            }

            if (is_null($parameter)) {
                throw new ParameterNotFoundException(
                    "Can not resolve parameter '$name' of type '$type' in method '{$method->getName()}' of class '$calledClass'"
                );
            }

            $args[$name] = $parameter;
        }

        return $args;
    }

    /**
     * @param string $name
     * @param array $boundParameters
     * @return mixed
     */
    private function getBoundParameter(
        string $name,
        array $boundParameters
    ): mixed {
        return $boundParameters[$name] ?? null;
    }

    /**
     * @param ReflectionParameter $param
     * @param array $boundParameters
     * @return mixed
     * @throws ClassNotFoundException
     * @throws ContainerException
     * @throws ParameterNotFoundException
     * @throws ReflectionException
     */
    private function getNamedParameter(
        ReflectionParameter $param,
        array $boundParameters
    ): mixed {
        $name = $param->getName();
        $type = $param->getType();
        $typeName = $param->getType()->getName();

        if (!$type->isBuiltin()) {
            return $this->get($typeName, $boundParameters);
        }

        return $this->getBoundParameter($name, $boundParameters);
    }
}