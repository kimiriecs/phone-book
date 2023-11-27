<?php

declare(strict_types=1);

namespace App\Core\Exceptions;

use App\Core\Interfaces\CustomExceptionInterface;
use Exception;

/**
 * Class InvalidClassException
 *
 * @package App\Core\Exceptions
 */
class InvalidClassException extends Exception implements CustomExceptionInterface
{

}