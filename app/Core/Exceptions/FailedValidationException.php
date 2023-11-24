<?php

declare(strict_types=1);

namespace App\Core\Exceptions;

use App\Core\Interfaces\CustomExceptionInterface;
use Exception;

/**
 * Class FailedValidationException
 *
 * @package App\Core\Exceptions
 */
class FailedValidationException extends Exception implements CustomExceptionInterface
{

}