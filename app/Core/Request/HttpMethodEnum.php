<?php declare(strict_types=1);

namespace App\Core\Request;

/**
 * Class HttpMethodEnum
 *
 * @package App\Core\Request
 */
enum HttpMethodEnum : string
{
    case GET = 'GET';
    case POST = 'POST';
    case PUT = 'PUT';
    case PATCH = 'PATCH';
    case DELETE = 'DELETE';
    case SUB_METHOD_FIELD_NAME = 'sub_method';
}
