<?php

declare(strict_types=1);

namespace Modules\User\Actions\Web\Auth;

use App\Core\App;
use App\Core\Auth\Auth;
use App\Core\View\View;
use Modules\User\DTO\Web\Pages\AuthFormPageDto;
use Exception;

/**
 * Class RenderAuthFormPage
 *
 * @package Modules\User\Actions\Web\Pages
 */
class RenderAuthFormPage
{
    /**
     * @param bool $isRegister
     * @return void
     * @throws Exception
     */
    public function execute(bool $isRegister): void
    {
        $previousUri = App::request()->prevUri();
        $showLoginErrors = !$isRegister && ($previousUri === App::router()->uri('login') || $previousUri === App::router()->uri('login.show'));
        $showRegisterErrors = $isRegister && ($previousUri === App::router()->uri('register') || $previousUri === App::router()->uri('register.show'));

        if ($showLoginErrors || $showRegisterErrors) {
            $errorBag = App::errorBag()->all();
            $oldInput = App::errorBag()->getOld();
        }

        $pageDto = new AuthFormPageDto(
            isRegister: $isRegister,
            oldEmail: $oldInput['email'] ?? null,
            oldPassword: $oldInput['password'] ?? null,
            oldPasswordConfirmation: $oldInput['password_confirmation'] ?? null,
            authErrors: $errorBag[Auth::SESSION_AUTH_ERROR_KEY] ?? null,
            emailErrors: $errorBag['email'] ?? null,
            passwordErrors: $errorBag['password'] ?? null,
            passwordConfirmationErrors: $errorBag['password_confirmation'] ?? null,
        );

        $content = 'auth';
        View::render('base', compact('content', 'pageDto'));
    }
}