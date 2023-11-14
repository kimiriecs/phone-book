<?php

declare(strict_types=1);

namespace App\Core\Exceptions;

use Psr\Container\ContainerExceptionInterface;

/**
 * Class ContainerException
 *
 * @package App\Core\Exceptions
 */
class ContainerException extends \Exception implements ContainerExceptionInterface
{

}