<?php

declare(strict_types=1);

namespace App\Core\Request\Validation\Rules\Handlers;

use App\Core\App;
use App\Core\ErrorHandler\ErrorHandler;
use App\Core\Request\Validation\Rules\Rule;
use Exception;
use Throwable;

/**
 * Class Regex
 *
 * @package App\Core\Request\Validation\Rules\Handlers
 */
class Regex extends Rule
{
    const PATTERN_ARGUMENT_POSITION = 0;
    const FULL_MATCH_POSITION = 0;

    /**
     * @param string $field
     * @param mixed $value
     * @return void
     * @throws Exception
     */
    public function handle(string $field, mixed $value): void
    {
        $pattern = $this->args[self::PATTERN_ARGUMENT_POSITION] ?? null;

        if (! $pattern) {
            throw new Exception("Invalid argument in " . self::class . " rule definition");
        }

        try {
            $res = preg_match($pattern, $value, $matches, PREG_UNMATCHED_AS_NULL);

            if ($res === false) {
                throw new Exception("Error in " . self::class);
            }
        } catch (Throwable $e) {
            ErrorHandler::handleExceptions($e);
        }


        if (! isset($matches[self::FULL_MATCH_POSITION])) {
            App::errorBag()->add($field, "Field $field must be a valid phone number in format: +380223334455");
        }
    }
}