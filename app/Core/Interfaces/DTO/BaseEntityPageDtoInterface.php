<?php

declare(strict_types=1);

namespace App\Core\Interfaces\DTO;

/**
 * Interface BaseEntityPageDtoInterface
 *
 * @package App\Core\Interfaces\DTO
 */
interface BaseEntityPageDtoInterface
{
    /**
     * @return string
     */
    public function getPage(): string;

    /**
     * @return array
     */
    public function getFields(): array;

    /**
     * @return array|null
     */
    public function getIncludes(): ?array;
}