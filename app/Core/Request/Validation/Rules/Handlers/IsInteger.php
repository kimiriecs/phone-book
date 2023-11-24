<?php

declare(strict_types=1);

namespace App\Core\Request\Validation\Rules\Handlers;

use App\Core\App;
use App\Core\Request\Validation\Rules\Rule;
use Exception;

/**
 * Class IsInteger
 *
 * @package App\Core\Request\Validation\Rules\Handlers
 */
class IsInteger extends Rule
{
    /**
     * @param string $field
     * @param mixed $value
     * @return void
     * @throws Exception
     */
    public function handle(string $field, mixed $value): void
    {
        if (!filter_var($value, FILTER_VALIDATE_INT)) {
            App::errorBag()->add($field, "Field $field must be an integer");
        }
    }
}