<?php

declare(strict_types=1);

namespace App\Core\Interfaces\DTO;

use App\Core\Entity\Entity;

/**
 * Interface EntityIndexPageDtoInterface
 *
 * @package App\Core\Interfaces\DTO
 */
interface EntityIndexPageDtoInterface extends BaseEntityPageDtoInterface
{
    /**
     * @return array<Entity>
     */
    public function getEntities(): array;
}