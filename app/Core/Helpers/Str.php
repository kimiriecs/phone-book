<?php declare(strict_types=1);

namespace App\Core\Helpers;

/**
 * Class Str
 *
 * @package App\Core\Helpers
 */
class Str
{
    /**
     * @param string $string
     * @param string|null $delimiter
     * @return string
     */
    public static function camel(string $string, ?string $delimiter = '_'): string
    {
        $words = explode($delimiter, strtolower($string));

        $result = '';
        foreach ($words as $word) {
            $result .= ucfirst(trim($word));
        }

        return lcfirst($result);
    }

    /**
     * @param $string
     * @return string
     */
    public static function snake($string): string
    {
        return strtolower(preg_replace('/(?<!^)[A-Z]/', '_$0', $string));
    }
}