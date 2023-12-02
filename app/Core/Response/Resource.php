<?php

declare(strict_types=1);

namespace App\Core\Response;

use App\Core\Entity\Entity;

/**
 * Class Resource
 *
 * @package App\Core\Response
 */
abstract class Resource
{
    /**
     * @var Entity $entity
     */
    protected Entity $entity;

    /**
     * @return array
     */
    abstract public function toArray(): array;

    /**
     * @param Entity $entity
     * @return array
     */
    public static function make(Entity $entity): array
    {
        $resource = (new static());

        $resource->entity = $entity;

        return $resource->toArray();
    }

    /**
     * @param array $data
     * @return array
     */
    public static function collection(array $data): array
    {
        return array_map(function (Entity $entity) {
            return static::make($entity);
        }, $data);
    }
}