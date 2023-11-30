<?php

declare(strict_types=1);

namespace App\Core\Entity;

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
    abstract static public function fields(): array;

    /**
     * @return array
     */
    abstract public function toArray(): array;
}