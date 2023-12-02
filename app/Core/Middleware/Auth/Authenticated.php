<?php

declare(strict_types=1);

namespace App\Core\Middleware\Auth;

use App\Core\App;
use App\Core\Middleware\Middleware;
use App\Core\Request\Request;
use Closure;

/**
 * Class Authenticated
 *
 * @package App\Core\Middleware\Auth
 */
class Authenticated extends Middleware
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        if (! App::auth()->check()) {
            $redirectUri = match ($request->uri()) {
                App::router()->uri('logout') => App::router()->uri('welcome'),
                default => App::router()->uri('login.show')
            };

            App::response()->redirect($redirectUri);
        }

        return $next($request);
    }
}