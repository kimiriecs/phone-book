<?php

declare(strict_types=1);

namespace App\Modules\Contact\DTO\Web\Pages;

use App\Core\Interfaces\DTO\EntityShowPageDtoInterface;

/**
 * Class ContactShowPageDto
 *
 * @package App\Modules\Contact\DTO\Web\Pages
 */
class ContactShowPageDto implements EntityShowPageDtoInterface
{
    /**
     * @param string $page
     * @param array $fields
     * @param array|null $includes
     */
    public function __construct(
        protected string $page,
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