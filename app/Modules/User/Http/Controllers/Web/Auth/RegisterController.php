<?php declare(strict_types=1);

namespace Modules\User\Http\Controllers\Web\Auth;

use App\Core\App;
use App\Core\Controller\WebController;
use Exception;
use Modules\User\Actions\Web\Auth\MakeRegistration;
use Modules\User\Actions\Web\Auth\RenderAuthFormPage;
use Modules\User\DTO\Web\Auth\RegisterDto;
use Modules\User\Http\Requests\Web\Auth\RegisterRequest;

/**
 * Class RegisterController
 *
 * @package Modules\User\Http\Controllers\Web
 */
class RegisterController extends WebController
{
    /**
     * @param RenderAuthFormPage $action
     * @return void
     * @throws Exception
     */
    public function showRegister(RenderAuthFormPage $action): void
    {
        App::session()->setCsrf();
        $action->execute(true);
    }

    /**
     * @param RegisterRequest $request
     * @param MakeRegistration $action
     * @return void
     * @throws Exception
     */
    public function register(RegisterRequest $request, MakeRegistration $action): void
    {
        $dto = RegisterDto::fromRequest($request);
        $action->execute($dto);
    }
}