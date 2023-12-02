<?php

declare(strict_types=1);

namespace App\Core\Middleware\Auth;

use App\Core\App;
use App\Core\Middleware\Middleware;
use App\Core\Request\Request;
use Closure;

/**
 * Class UnAuthenticated
 *
 * @package App\Core\Middleware\Auth
 */
class UnAuthenticated extends Middleware
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        $authUris = [
            App::router()->uri('login.show'),
            App::router()->uri('login'),
            App::router()->uri('register.show'),
            App::router()->uri('register'),
        ];

        if (App::auth()->check() && in_array($request->uri(), $authUris)) {
            App::response()->redirect(App::router()->uri('welcome'));
        }

        return $next($request);
    }
}