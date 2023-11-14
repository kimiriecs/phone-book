<?php

declare(strict_types=1);

namespace App\Core\Exceptions;

use Psr\Container\NotFoundExceptionInterface;

/**
 * Class ParameterNotFoundException
 *
 * @package App\Core\Exceptions
 */
class ParameterNotFoundException extends \Exception implements NotFoundExceptionInterface
{

}