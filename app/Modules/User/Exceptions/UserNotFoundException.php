<?php

declare(strict_types=1);

namespace Modules\User\Exceptions;

use App\Core\Interfaces\CustomExceptionInterface;
use Exception;

/**
 * Class UserNotFoundException
 *
 * @package Modules\User\Exceptions
 */
class UserNotFoundException extends Exception implements CustomExceptionInterface
{

}