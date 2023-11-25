<?php

declare(strict_types=1);

namespace App\Modules\User\Exceptions;

use App\Core\Interfaces\CustomExceptionInterface;
use Exception;

/**
 * Class UserNotFoundException
 *
 * @package App\Modules\User\Exceptions
 */
class UserNotFoundException extends Exception implements CustomExceptionInterface
{

}