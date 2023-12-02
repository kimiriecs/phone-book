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

    const SHORT_FULL_NAME_LENGTH = 10;

    /**
     * @param int $id
     * @param int $userId
     * @param string $firstName
     * @param string $lastName
     * @param string $phone
     * @param string $email
     * @param bool $isFavorite
     * @param DateTime|string $createdAt
     */
    public function __construct(
        protected int $id,
        protected int $userId,
        protected string $firstName,
        protected string $lastName,
        protected string $phone,
        protected string $email,
        protected bool $isFavorite,
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
    public function getShortFirstName(): string
    {
        return $this->getShortName($this->getFirstName());
    }

    /**
     * @return string
     */
    public function getShortLastName(): string
    {
        return $this->getShortName($this->getLastName());
    }

    /**
     * @return string
     */
    public function getFullName(): string
    {
        return $this->getFirstName() . ' ' . $this->getLastName();
    }

    /**
     * @param string $name
     * @return string
     */
    public function getShortName(string $name): string
    {
        return strlen($name) > self::SHORT_FULL_NAME_LENGTH
            ? substr_replace($name, '...', self::SHORT_FULL_NAME_LENGTH)
            : $name;
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
     * @return bool
     */
    public function isFavorite(): bool
    {
        return $this->isFavorite;
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
    public static function fields(): array
    {
        return [
            'id',
            'first_name',
            'last_name',
            'full_name',
            'phone',
            'email',
            'is_favorite',
            'created_at',
        ];
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'first_name' => $this->getFirstName(),
            'last_name' => $this->getLastName(),
            'full_name' => $this->getFullName(),
            'phone' => $this->getPhone(),
            'email' => $this->getEmail(),
            'is_favorite' => $this->isFavorite(),
            'created_at' => $this->getCreatedAt(),
        ];
    }
}