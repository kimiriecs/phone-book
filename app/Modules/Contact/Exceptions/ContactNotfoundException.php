<?php

declare(strict_types=1);

namespace App\Modules\Contact\Exceptions;

use App\Core\Interfaces\CustomExceptionInterface;
use Exception;

/**
 * Class ContactNotfoundException
 *
 * @package App\Modules\Contact\Exceptions
 */
class ContactNotfoundException extends Exception implements CustomExceptionInterface
{

}