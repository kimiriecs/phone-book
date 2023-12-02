<?php declare(strict_types=1);

namespace App\Core\Logger;

use Monolog\Formatter\LineFormatter;

/**
 * Class CustomLineFormatter
 *
 * @package App\Core\Logger
 */
class CustomLineFormatter extends LineFormatter
{
    public function stringify($value): string
    {
        if (is_array($value)) {
            return implode("\n", array_map(function($traceLine) {
                return json_encode($traceLine, JSON_PRETTY_PRINT);
            }, $value));
        }

        return parent::stringify($value);
    }
}