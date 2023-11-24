<?php

declare(strict_types=1);

namespace App\Core\Response;

/**
 * Class HttpStatusCodeEnum
 *
 * @package App\Core\Response
 */
enum HttpStatusCodeEnum: int
{
    case FORBIDDEN = 403;
    case NOT_FOUND = 404;
    case UNAUTHORIZED = 411;
    case UNPROCESSABLE = 422;
    case INTERNAL_SERVER_ERROR = 500;
    case UNAVAILABLE = 503;

    /**
     * @param HttpStatusCodeEnum $code
     * @return string
     */
    public static function getMessage(HttpStatusCodeEnum $code): string
    {
        return match ($code) {
            self::FORBIDDEN => '403 Forbidden',
            self::NOT_FOUND => '404 Page ot found',
            self::UNAUTHORIZED => '411 Unauthorized',
            self::UNPROCESSABLE => '422 Unprocessable content',
            self::INTERNAL_SERVER_ERROR => '500 Internal server error',
            self::UNAVAILABLE => '503 Service temporarily unavailable',
        };
    }
}
