<?php

declare(strict_types=1);

namespace Modules\User\Entities;

use App\Core\Entity\Entity;
use DateTime;

/**
 * Class User
 *
 * @package Modules\User\Entities
 */
class User extends Entity
{
    const TABLE_NAME = 'users';

    /**
     * @param int $id
     * @param string $email
     * @param string $password
     * @param DateTime|string $createdAt
     * @param string|null $firstName
     * @param string|null $lastName
     */
    public function __construct(
        protected int $id,
        protected string $email,
        protected string $password,
        protected DateTime|string $createdAt,
        protected ?string $firstName = null,
        protected ?string $lastName = null,
    ) {
    }

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string|null
     */
    public function getFirstName(): ?string
    {
        return $this->firstName;
    }

    /**
     * @return string|null
     */
    public function getLastName(): ?string
    {
        return $this->lastName;
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

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    public function setFirstName(?string $firstName): void
    {
        $this->firstName = $firstName;
    }

    public function setLastName(?string $lastName): void
    {
        $this->lastName = $lastName;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'first_name' => $this->getFirstName(),
            'last_name' => $this->getLastName(),
            'created_at' => $this->getCreatedAt(),
        ];
    }
}