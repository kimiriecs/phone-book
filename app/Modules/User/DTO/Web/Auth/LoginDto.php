<?php declare(strict_types=1);

namespace Modules\User\DTO\Web\Auth;

use Modules\User\Http\Requests\Web\Auth\LoginRequest;

/**
 * Class LoginDto
 *
 * @package Modules\User\DTO\Web\Auth
 */
class LoginDto
{
    /**
     * @param string $email
     * @param string $password
     */
    public function __construct(
        protected string $email,
        protected string $password,
    ) {
    }

    /**
     * @param LoginRequest $request
     * @return LoginDto
     */
    public static function fromRequest(LoginRequest $request): LoginDto
    {
        return new static(
            email: $request->post('email'),
            password: $request->post('password')
        );
    }

    /**
     * @param array $data
     * @return LoginDto
     */
    public static function fromArray(array $data): LoginDto
    {
        return new static(
            email: $data['email'] ?? null,
            password: $data['password'] ?? null
        );
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }
}