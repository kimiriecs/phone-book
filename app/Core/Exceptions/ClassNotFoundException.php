<?php

declare(strict_types=1);

namespace App\Core\Exceptions;

use Psr\Container\NotFoundExceptionInterface;

/**
 * Class ClassNotFoundException
 *
 * @package App\Core\Exceptions
 */
class ClassNotFoundException extends \Exception implements NotFoundExceptionInterface
{

}