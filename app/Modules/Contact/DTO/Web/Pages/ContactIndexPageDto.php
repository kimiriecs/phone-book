<?php

declare(strict_types=1);

namespace App\Modules\Contact\DTO\Web\Pages;

use App\Core\Interfaces\DTO\EntityIndexPageDtoInterface;
use App\Modules\Contact\Entities\Contact;

/**
 * Class ContactIndexPageDto
 *
 * @package App\Modules\Contact\DTO\Web\Pages
 */
class ContactIndexPageDto implements EntityIndexPageDtoInterface
{
    /**
     * @param string $page
     * @param array<Contact> $entities
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
     * @return array<Contact>
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