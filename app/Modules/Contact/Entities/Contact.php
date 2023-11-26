<?php

declare(strict_types=1);

namespace App\Modules\Contact\Entities;

use App\Core\Entity\Entity;
use DateTime;

/**
 * Class Contact
 *
 * @package App\Modules\Contact\Entities
 */
class Contact extends Entity
{
    const TABLE_NAME = 'contacts';

    /**
     * @param int $id
     * @param int $userId
     * @param string $firstName
     * @param string $lastName
     * @param string $phone
     * @param string $email
     * @param DateTime|string $createdAt
     */
    public function __construct(
        protected int $id,
        protected int $userId,
        protected string $firstName,
        protected string $lastName,
        protected string $phone,
        protected string $email,
        protected DateTime|string $createdAt,
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
     * @return int
     */
    public function getUserId(): int
    {
        return $this->userId;
    }

    /**
     * @return string
     */
    public function getFirstName(): string
    {
        return $this->firstName;
    }

    /**
     * @return string
     */
    public function getLastName(): string
    {
        return $this->lastName;
    }

    /**
     * @return string
     */
    public function getPhone(): string
    {
        return $this->phone;
    }

    /**
     * @return string
     */
    public function getEmail(): string
    {
        return $this->email;
    }

    /**
     * @return DateTime|string
     */
    public function getCreatedAt(): DateTime|string
    {
        return $this->createdAt;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'first_name' => $this->getFirstName(),
            'last_name' => $this->getLastName(),
            'phone' => $this->getPhone(),
            'email' => $this->getEmail(),
            'created_at' => $this->getCreatedAt(),
        ];
    }
}