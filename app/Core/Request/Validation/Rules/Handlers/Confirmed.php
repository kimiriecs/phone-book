<?php

declare(strict_types=1);

namespace App\Core\Request\Validation\Rules\Handlers;

use App\Core\App;
use App\Core\Request\Validation\Rules\Rule;
use Exception;

/**
 * Class Confirmed
 *
 * @package App\Core\Request\Validation\Rules\Handlers
 */
class Confirmed extends Rule
{
    const CONFIRMATION_FIELD_NAME_ARGUMENT_POSITION = 0;

    /**
     * @param string $field
     * @param mixed $value
     * @return void
     * @throws Exception
     */
    public function handle(string $field, mixed $value): void
    {
        $confirmFieldName = $this->args[self::CONFIRMATION_FIELD_NAME_ARGUMENT_POSITION] ?? null;

        if (! is_string($confirmFieldName) || trim($confirmFieldName) === '') {
            throw new Exception("Invalid argument in " . self::class . " rule definition");
        }

        $confirmFieldValue = $this->data[$confirmFieldName] ?? null;
        $passwordNotConfirmed = !isset($value) || ($value !== $confirmFieldValue);

        if ($passwordNotConfirmed) {
            App::errorBag()->add($confirmFieldName, "Field $field must be confirmed");
        }
    }
}