<?php

declare(strict_types=1);

namespace App\Core\Request\Validation\Rules\Handlers;

use App\Core\App;
use App\Core\Request\Validation\Rules\Rule;
use Exception;

/**
 * Class IsArray
 *
 * @package App\Core\Request\Validation\Rules\Handlers
 */
class IsArray extends Rule
{
    /**
     * @param string $field
     * @param mixed $value
     * @return void
     * @throws Exception
     */
    public function handle(string $field, mixed $value): void
    {
        if (!is_array($value)) {
            App::errorBag()->add($field, "Field $field must be an array");
        }
    }
}