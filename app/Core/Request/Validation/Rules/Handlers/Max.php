<?php

declare(strict_types=1);

namespace App\Core\Request\Validation\Rules\Handlers;

use App\Core\App;
use App\Core\Request\Validation\Rules\Rule;
use Exception;

/**
 * Class Max
 *
 * @package App\Core\Request\Validation\Rules\Handlers
 */
class Max extends Rule
{
    const MAX_LENGTH_ARGUMENT_POSITION = 0;

    /**
     * @param string $field
     * @param mixed $value
     * @return void
     * @throws Exception
     */
    public function handle(string $field, mixed $value): void
    {
        $maxLength = $this->args[self::MAX_LENGTH_ARGUMENT_POSITION] ?? null;

        if (filter_var($maxLength, FILTER_VALIDATE_INT) === false) {
            throw new Exception("Invalid data type for argument in " . self::class . " rule definition");
        }

        if (!($maxLength > 0)) {
            throw new Exception("Argument in " . self::class . " rule definition must be greater then '0'");
        }

        if (is_null($value) || (strlen($value) > $maxLength)) {
            App::errorBag()->add($field, "Field $field must not be longer than " . $maxLength . " characters");
        }
    }
}