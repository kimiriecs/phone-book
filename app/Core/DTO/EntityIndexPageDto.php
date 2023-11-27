<?php

declare(strict_types=1);

namespace App\Core\DTO;

/**
 * Class EntityIndexPageDto
 *
 * @package App\Core\DTO
 */
class EntityIndexPageDto extends BaseEntityPageDto
{
    /**
     * @param string $page
     * @param array $entities
     * @param array $fields
     * @param array|null $includes
     */
    public function __construct(
        protected string $page,
        protected array $entities,
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
     * @return array
     */
    public function getEntities(): array
    {
        return $this->entities;
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