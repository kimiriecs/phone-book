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
class Exists extends Rule
{
    const TABLE_NAME_ARGUMENT_POSITION = 0;
    const COLUMN_NAME_ARGUMENT_POSITION = 1;

    /**
     * @param string $field
     * @param mixed $value
     * @return void
     * @throws Exception
     */
    public function handle(string $field, mixed $value): void
    {
        $table = $this->args[self::TABLE_NAME_ARGUMENT_POSITION] ?? null;
        $column = $this->args[self::COLUMN_NAME_ARGUMENT_POSITION] ?? null;

        if (! $table || ! $column) {
            throw new Exception("Invalid arguments in " . self::class . " rule definition");
        }

        $query = "SELECT EXISTS(SELECT 1 FROM $table WHERE $column = :$column)";
        $exists = App::db()->connect()->prepare($query)->execute([$column => $value]);

        if (!$exists) {
            App::errorBag()->add($field, "The selected $field is invalid");
        }
    }
}