<?php

declare(strict_types=1);

namespace App\Core\Request\Validation\Rules\Handlers;

use App\Core\App;
use App\Core\Request\Validation\Rules\Rule;
use Exception;

/**
 * Class Required
 *
 * @package App\Core\Request\Validation\Rules\Handlers
 */
class Required extends Rule
{
    /**
     * @param string $field
     * @param mixed $value
     * @return void
     * @throws Exception
     */
    public function handle(string $field, mixed $value): void
    {
        if (is_null($value) || (is_string($value) && trim($value) === '')) {
            App::errorBag()->add($field, "Field $field is required");
        }
    }
}