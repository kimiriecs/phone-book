<?php declare(strict_types=1);

namespace App\Core\Middleware\Auth;

use App\Core\App;
use App\Core\Helpers\Str;
use App\Core\Middleware\Middleware;
use App\Core\Request\HttpMethodEnum;
use App\Core\Request\Request;
use App\Core\Response\HttpStatusCodeEnum;
use App\Core\Session\Session;
use Closure;

/**
 * Class VerifyCsrfToken
 *
 * @package App\Core\Middleware\Auth
 */
class VerifyCsrfToken extends Middleware
{
    /**
     * @param Request $request
     * @param Closure $next
     * @return mixed
     */
    public function handle(Request $request, Closure $next): mixed
    {
        if ($request->method() === HttpMethodEnum::GET->value) {
            return $next($request);
        }

        $csrfToken = $request->post(Session::SESSION_CSRF_TOKEN_KEY);
        if (!$csrfToken || ! App::session()->checkCsrf($csrfToken)) {
            App::response()->redirect(
                App::router()->uri(
                    Str::camel(HttpStatusCodeEnum::FORBIDDEN->name)
                )
            );
        }

        return $next($request);
    }
}