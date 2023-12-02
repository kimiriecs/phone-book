<?php

declare(strict_types=1);

namespace App\Core\Exceptions;

use App\Core\Interfaces\CustomExceptionInterface;
use Exception;

/**
 * Class InvalidUriException
 *
 * @package App\Core\Exceptions
 */
class InvalidUriException extends Exception implements CustomExceptionInterface
{

}