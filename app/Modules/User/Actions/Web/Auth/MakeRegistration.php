<?php declare(strict_types=1);

namespace Modules\User\Actions\Web\Auth;

use App\Core\App;
use Exception;
use Modules\User\DTO\Web\Auth\RegisterDto;
use Modules\User\Interfaces\Repositories\UserRepositoryInterface;

/**
 * Class MakeRegistration
 *
 * @package Modules\User\Actions\Web\Auth
 */
class MakeRegistration
{
    /**
     * @param UserRepositoryInterface $repository
     */
    public function __construct(
        protected UserRepositoryInterface $repository
    ) {
    }

    /**
     * @param RegisterDto $dto
     * @return void
     * @throws Exception
     */
    public function execute(RegisterDto $dto): void
    {
        $userExists = $this->repository->exists(['email' => $dto->getEmail()]);

        if ($userExists) {
            $error = ['email' => ['User with provided email already exists']];
            App::session()->set('errorBag', $error);
            header("Location: " . App::router()->uri('register.show'));

            return;
        }

        try {
            $this->repository->insert($dto->toArray());
        } catch (Exception $e) {
            App::log()->error($e->getMessage(), ['Trace' => $e->getTrace()]);
        }

        App::session()->setCsrf();
        App::session()->set('errorBag', []);
        App::session()->set('oldInput', []);
        App::response()->redirect(App::router()->uri('login.show'));
    }
}