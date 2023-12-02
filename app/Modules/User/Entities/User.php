<?php

declare(strict_types=1);

namespace Modules\User\Entities;

use App\Core\App;
use App\Core\Entity\Entity;
use DateTime;
use Modules\Contact\Interfaces\Repositories\ContactRepositoryInterface;

/**
 * Class User
 *
 * @package Modules\User\Entities
 */
class User extends Entity
{
    const TABLE_NAME = 'users';

    /**
     * @var ContactRepositoryInterface|null $contactRepository
     */
    protected ?ContactRepositoryInterface $contactRepository = null;

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

    public function contacts(): array
    {
        return $this->getContactRepository()->findBy(['user_id' => $this->getId()]);
    }

    /**
     * @return ContactRepositoryInterface
     */
    private function getContactRepository(): ContactRepositoryInterface
    {
        if (! $this->contactRepository) {
            $this->contactRepository = App::instance()->make(ContactRepositoryInterface::class);
        }

        return $this->contactRepository;
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
            'email',
            'password',
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
            'email' => $this->getEmail(),
            'password' => $this->getPassword(),
            'created_at' => $this->getCreatedAt(),
        ];
    }
}