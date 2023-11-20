<?php

declare(strict_types=1);

namespace App\Core\Middleware;

use App\Core\Request\Request;
use Closure;

/**
 * Class Middleware
 *
 * @package App\Core\Middleware
 */
abstract class Middleware
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return mixed|void
     */
    abstract public function handle(Request $request, Closure $next);
}