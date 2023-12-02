<?php

declare(strict_types=1);

namespace App\Core\Request\Validation\Rules;

use App\Core\App;

/**
 * Class Rule
 *
 * @package App\Core\Request\Validation\Rules
 */
abstract class Rule
{
    /**
     * @param array|null $data
     * @param array|null $args
     */
    public function __construct(
        protected ?array $data = [],
        protected ?array $args = []
    ) {
    }

    /**
     * @param string $field
     * @param mixed $value
     * @return void
     */
    abstract public function handle(string $field, mixed $value): void;
}