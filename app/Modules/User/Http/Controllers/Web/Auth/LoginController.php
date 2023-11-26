<?php declare(strict_types=1);

namespace Modules\User\Http\Controllers\Web\Auth;

use App\Core\App;
use App\Core\Controller\WebController;
use Modules\User\Actions\Web\Auth\MakeLogin;
use Modules\User\Actions\Web\Auth\RenderAuthFormPage;
use Modules\User\Http\Requests\Web\Auth\LoginRequest;
use Exception;
use JetBrains\PhpStorm\NoReturn;
use Modules\User\DTO\Web\Auth\LoginDto;

/**
 * Class LoginController
 *
 * @package Modules\User\Http\Controllers\Web
 */
class LoginController extends WebController
{
    /**
     * @param RenderAuthFormPage $action
     * @return void
     * @throws Exception
     */
    public function showLogin(RenderAuthFormPage $action): void
    {
        App::session()->setCsrf();
        $action->execute(false);
    }

    /**
     * @param LoginRequest $request
     * @param MakeLogin $action
     * @return void
     * @throws Exception
     */
    public function login(LoginRequest $request, MakeLogin $action): void
    {
        $dto = LoginDto::fromRequest($request);
        $action->execute($dto);
    }

    /**
     * @return void
     */
    #[NoReturn]
    public function logout(): void
    {
        App::auth()->invalidate();
        App::response()->redirect(App::router()->uri('welcome'));
    }
}