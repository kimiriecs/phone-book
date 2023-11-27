<?php

declare(strict_types=1);

namespace App\Core\DTO;

use App\Core\Entity\Entity;

/**
 * Class EntityEditPageDto
 *
 * @package App\Core\DTO
 */
class EntityEditPageDto extends BaseEntityPageDto
{
    /**
     * @param string $page
     * @param Entity $entity
     * @param array $fields
     * @param array|null $includes
     */
    public function __construct(
        protected string $page,
        protected Entity $entity,
        protected array $fields,
        protected ?array $includes = null,
    ) {
    }

    /**
     * @return string
     */
    public function getPage(): string
    {
        return $this->page;
    }

    /**
     * @return Entity
     */
    public function getEntity(): Entity
    {
        return $this->entity;
    }

    /**
     * @return array
     */
    public function getFields(): array
    {
        return $this->fields;
    }

    /**
     * @return array|null
     */
    public function getIncludes(): ?array
    {
        return $this->includes;
    }
}