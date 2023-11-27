<?php

declare(strict_types=1);

namespace App\Core\DTO;

/**
 * Class BaseEntityPageDto
 *
 * @package App\Core\DTO
 */
abstract class BaseEntityPageDto
{
    abstract public function getPage(): string;
    abstract public function getIncludes(): ?array;
}