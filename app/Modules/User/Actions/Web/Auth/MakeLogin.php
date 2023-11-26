<?php

declare(strict_types=1);

namespace Modules\User\Actions\Web\Auth;

use App\Core\App;
use Exception;
use Modules\User\DTO\Web\Auth\LoginDto;

/**
 * Class MakeLogin
 *
 * @package Modules\User\Actions\Web\Auth
 */
class MakeLogin
{
    /**
     * @param LoginDto $dto
     * @return void
     * @throws Exception
     */
    public function execute(LoginDto $dto): void
    {
        try {
            $user = App::auth()->attempt($dto->getEmail(), $dto->getPassword());
            App::session()->setCsrf();
            $uri = App::router()->uri('dashboard', ['userId' => $user->getId()]);
            App::response()->redirect($uri);
        } catch (Exception $e) {
            App::log()->error($e->getMessage(), ['Trace' => $e->getTrace()]);
        }
    }
}