<?php

declare(strict_types=1);

namespace App\Modules\Contact\DTO\Web\Pages;

use App\Core\Interfaces\DTO\EntityEditPageDtoInterface;
use App\Modules\Contact\Entities\Contact;

/**
 * Class ContactShowPageDto
 *
 * @package App\Modules\Contact\DTO\Web\Pages
 */
class ContactEditPageDto implements EntityEditPageDtoInterface
{
    /**
     * @param string $page
     * @param array $fields
     * @param array $errors
     * @param array $oldInput
     * @param array|null $includes
     */
    public function __construct(
        protected string $page,
        protected array $fields,
        protected array $errors,
        protected array $oldInput,
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
     * @return Contact
     */
    public function getEntity(): Contact
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
     * @return array
     */
    public function getErrors(): array
    {
        return $this->errors;
    }

    /**
     * @return array
     */
    public function getOldInput(): array
    {
        return $this->oldInput;
    }

    /**
     * @return array|null
     */
    public function getIncludes(): ?array
    {
        return $this->includes;
    }
}