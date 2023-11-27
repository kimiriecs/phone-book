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
     * @return string
     */
    public static function camel(string $string): string
    {
        $str = str_replace('-', '_', $string);
        $words = explode('_', lcfirst($str));

        $result = array_shift($words);
        foreach ($words as $word) {
            $result .= ucfirst($word);
        }

        return $result;
    }

    /**
     * @param $string
     * @return string
     */
    public static function snake($string): string
    {
        $str = preg_replace('/(?<!^)[A-Z]/', '_$0', $string);

        return str_replace('-', '_', strtolower($str));
    }
}