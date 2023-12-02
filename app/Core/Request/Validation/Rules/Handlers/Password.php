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
class Password extends Rule
{
    const LOWER_ARGUMENT_POSITION = 0;
    const UPPER_ARGUMENT_POSITION = 1;
    const SPECIAL_ARGUMENT_POSITION = 2;

    /**
     * @param string $field
     * @param mixed $value
     * @return void
     * @throws Exception
     */
    public function handle(string $field, mixed $value): void
    {
        $lowerCaseSymbolRequired = $this->args[self::LOWER_ARGUMENT_POSITION] ?? null;
        $upperCaseSymbolRequired = $this->args[self::UPPER_ARGUMENT_POSITION] ?? null;
        $specialSymbolRequired = $this->args[self::SPECIAL_ARGUMENT_POSITION] ?? null;

        if ($lowerCaseSymbolRequired && ! is_bool($lowerCaseSymbolRequired)) {
            throw new Exception("Invalid argument "
                . self::LOWER_ARGUMENT_POSITION
                .  " in " . self::class . " rule definition: boolean value expected");
        }

        if ($upperCaseSymbolRequired && ! is_bool($upperCaseSymbolRequired)) {
            throw new Exception("Invalid argument "
                . self::UPPER_ARGUMENT_POSITION
                . " in " . self::class . " rule definition: boolean value expected");
        }

        if ($specialSymbolRequired && ! is_bool($specialSymbolRequired)) {
            throw new Exception("Invalid argument "
                . self::SPECIAL_ARGUMENT_POSITION
                . " in " . self::class . " rule definition: boolean value expected");
        }

        try {
            $res = false;
            if ($lowerCaseSymbolRequired) {
                $res = preg_match("/(?<lover>[a-z]+)/", $value, $matches, PREG_UNMATCHED_AS_NULL);

                if (!isset($matches['lover'])) {
                    App::errorBag()->add($field, "Field $field must contain at least one lowercase character");
                }
            }

            if ($upperCaseSymbolRequired) {
                $res = preg_match("/(?<upper>[A-Z]+)/", $value, $matches, PREG_UNMATCHED_AS_NULL);

                if (!isset($matches['upper'])) {
                    App::errorBag()->add($field, "Field $field must contain at least one uppercase character");
                }
            }

            if ($specialSymbolRequired) {
                $res = preg_match("/(?<special>[~`!@#$%^&*()_\-+={}\[\]|\\\:;\"'<,>.?\/]+)/", $value, $matches, PREG_UNMATCHED_AS_NULL);

                if (!isset($matches['special'])) {
                    App::errorBag()->add($field, "Field $field must contain at least one special character");
                }
            }

            if ($res === false) {
                throw new Exception("Error in " . self::class);
            }
        } catch (Throwable $e) {
            ErrorHandler::handleExceptions($e);
        }
    }
}