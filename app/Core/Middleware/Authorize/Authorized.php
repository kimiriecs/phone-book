<?php declare(strict_types=1);

namespace App\Core\Middleware\Authorize;

use App\Core\App;
use App\Core\Middleware\Middleware;
use App\Core\Request\Request;
use Closure;

/**
 * Class Authorized
 *
 * @package App\Core\Middleware\Authorize
 */
class Authorized extends Middleware
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        if (App::auth()->id() && $request->route()->getParameter('userId')
            && $request->route()->getParameter('userId') !== (App::auth()->id())
        ) {
            $prevUri = $request->prevUri();
            App::response()->redirect($prevUri);
        }

        return $next($request);
    }
}