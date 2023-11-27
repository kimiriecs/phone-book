<?php

declare(strict_types=1);

namespace App\Core\Entity;

use ReflectionClass;

/**
 * Class Entity
 *
 * @package App\Core\Entity
 */
abstract class Entity
{
    /**
     * @var int $id
     */
    protected int $id;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return array
     */
    public static function fields(): array
    {
        $reflector = new ReflectionClass(static::class);
        $constructor = $reflector->getConstructor();

        return array_map(function ($property) {
            return $property->getName();
        }, $constructor->getParameters());
    }

    /**
     * @return array
     */
    abstract public function toArray(): array;
}