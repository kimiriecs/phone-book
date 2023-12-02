<?php

declare(strict_types=1);

namespace Modules\User\DTO\Web\Pages;

/**
 * Class AuthFormPageDto
 *
 * @package Modules\User\DTO\Web\Pages
 */
class AuthFormPageDto
{
    /**
     * @param bool $isRegister
     * @param string|null $oldEmail
     * @param string|null $oldPassword
     * @param string|null $oldPasswordConfirmation
     * @param array|null $authErrors
     * @param array|null $emailErrors
     * @param array|null $passwordErrors
     * @param array|null $passwordConfirmationErrors
     */
    public function __construct(
        protected bool $isRegister,
        protected ?string $oldEmail = null,
        protected ?string $oldPassword = null,
        protected ?string $oldPasswordConfirmation = null,
        protected ?array $authErrors = null,
        protected ?array $emailErrors = null,
        protected ?array $passwordErrors = null,
        protected ?array $passwordConfirmationErrors = null,
    ) {
    }

    /**
     * @return bool
     */
    public function isRegisterPage(): bool
    {
        return $this->isRegister;
    }

    /**
     * @return string|null
     */
    public function getOldEmail(): ?string
    {
        return $this->oldEmail;
    }

    /**
     * @return string|null
     */
    public function getOldPassword(): ?string
    {
        return $this->oldPassword;
    }

    /**
     * @return string|null
     */
    public function getOldPasswordConfirmation(): ?string
    {
        return $this->oldPasswordConfirmation;
    }

    /**
     * @return array|null
     */
    public function getAuthErrors(): ?array
    {
        return $this->authErrors;
    }

    /**
     * @return array|null
     */
    public function getEmailErrors(): ?array
    {
        return $this->emailErrors;
    }

    /**
     * @return array|null
     */
    public function getPasswordErrors(): ?array
    {
        return $this->passwordErrors;
    }

    /**
     * @return array|null
     */
    public function getPasswordConfirmationErrors(): ?array
    {
        return $this->passwordConfirmationErrors;
    }
}