<?php

declare(strict_types=1);

namespace App\Core\Auth;

use App\Core\App;
use App\Core\ErrorHandler\ErrorHandler;
use Modules\User\Exceptions\UserNotFoundException;
use Exception;
use Modules\User\Entities\User;
use Modules\User\Interfaces\Repositories\UserRepositoryInterface;
use ReflectionException;
use Throwable;

/**
 * Class Auth
 *
 * @package App\Core\Auth
 */
class Auth
{
    public const SESSION_AUTH_USER_KEY = 'auth_user_id';
    public const SESSION_AUTH_ERROR_KEY = 'auth_error';

    /**
     * @param UserRepositoryInterface $repository
     */
    public function __construct(
        protected UserRepositoryInterface $repository
    ) {
    }

    /**
     * @return User|null
     */
    public function user(): ?User
    {
        $id = $this->id();
        if (!$id) {
            return null;
        }

        try {
            $user = $this->repository->findById($id);
            if (!$user instanceof User) {
                throw new UserNotFoundException("User not found", 404);
            }

            return $user;
        } catch (Throwable $e) {
            ErrorHandler::handleExceptions($e);
        }
    }

    /**
     * @return int|null
     */
    public function id(): ?int
    {
        return App::session()->get(self::SESSION_AUTH_USER_KEY);
    }

    /**
     * @return bool
     */
    public function check(): bool
    {
        return session_status() === PHP_SESSION_ACTIVE && App::session()->has(self::SESSION_AUTH_USER_KEY);
    }

    /**
     * @param string $email
     * @param string $password
     * @return User
     * @throws ReflectionException
     * @throws Exception
     */
    public function attempt(string $email, string $password): User
    {
        $user = $this->repository->findOneBy(['email' => $email]);

        if (!$user) {
            App::errorBag()->add(self::SESSION_AUTH_ERROR_KEY, "Email or password incorrect");
            App::response()->redirect(App::router()->uri('login'));
        }

        /** @var User $user */
        if (!password_verify($password, $user->getPassword())) {
            App::errorBag()->add(self::SESSION_AUTH_ERROR_KEY, "Email or password incorrect");
            App::response()->redirect(App::router()->uri('login'));
        }

        $this->authenticate($user);

        return $user;
    }

    /**
     * @param User $user
     * @return void
     */
    public function authenticate(User $user): void
    {
        App::session()->set(self::SESSION_AUTH_USER_KEY, $user->getId());
    }

    /**
     * @return void
     */
    public function invalidate(): void
    {
        $_SESSION = [];
    }
}