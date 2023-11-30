<?php

declare(strict_types=1);

namespace App\Core\Interfaces\DTO;

/**
 * Interface EntityCreatePageDtoInterface
 *
 * @package App\Core\Interfaces\DTO
 */
interface EntityCreatePageDtoInterface extends BaseEntityPageDtoInterface
{
    /**
     * @return array
     */
    public function getErrors(): array;

    /**
     * @return array
     */
    public function getOldInput(): array;
}