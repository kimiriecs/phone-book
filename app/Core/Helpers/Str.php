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
        $i = array("-","_");
        $str = preg_replace('/([a-z])([A-Z])/', "\\1 \\2", $string);
        $str = preg_replace('/[^a-zA-Z0-9\-_ ]+/', '', $str);
        $str = str_replace($i, ' ', $str);
        $str = str_replace(' ', '', ucwords(strtolower($str)));

        return strtolower(substr($str,0,1)).substr($str,1);
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