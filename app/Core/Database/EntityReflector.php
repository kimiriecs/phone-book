<?php declare(strict_types=1);

namespace App\Core\Database;

use App\Core\Entity\Entity;
use App\Core\Helpers\Str;

/**
 * Class EntityReflector
 *
 * @package App\Core\Database
 */
class EntityReflector
{
    /**
     * @param string $entityClass
     * @param array $data
     * @return Entity
     * @throws \ReflectionException
     */
    public static function getEntity(string $entityClass, array $data): Entity
    {
        $reflectionClass = new \ReflectionClass($entityClass);

        // Preparing values for constructor
        // The order of parameters is following order of properties in the class
        $argumentsForConstructor = [];
        foreach ($reflectionClass->getProperties(\ReflectionProperty::IS_PROTECTED) as $property) {
            $propertyName = Str::snake($property->getName());
            $argumentsForConstructor[] = $data[$propertyName] ?? null;
        }

        // Creating new entity instance with data from DB
        /** @var Entity $entity */
        $entity = $reflectionClass->newInstance(...$argumentsForConstructor);

        return $entity;
    }
}