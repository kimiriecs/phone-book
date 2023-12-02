<?php

declare(strict_types=1);

namespace App\Modules\Contact\DTO\Web;

use App\Core\App;
use App\Core\Helpers\Config;
use App\Core\Request\FormRequest;
use DateTime;
use DateTimeZone;
use Exception;

/**
 * Class ContactDto
 *
 * @package App\Modules\Contact\DTO\Web
 */
class ContactDto
{
    protected ?int $id;
    protected int $userId;
    protected string $firstName;
    protected string $lastName;
    protected string $phone;
    protected string $email;
    protected bool $isFavorite;
    protected DateTime $createdAt;

    /**
     * @param int $userId
     * @param string $firstName
     * @param string $lastName
     * @param string $phone
     * @param string $email
     * @param bool $isFavorite
     * @param string|null $createdAt
     * @param int|null $id
     * @throws Exception
     */
    public function __construct(
        int $userId,
        string $firstName,
        string $lastName,
        string $phone,
        string $email,
        bool $isFavorite,
        ?string $createdAt = null,
        ?int $id = null,
    ) {
        $this->id = $id;
        $this->userId = $userId;
        $this->firstName = $firstName;
        $this->lastName = $lastName;
        $this->phone = $phone;
        $this->email = $email;
        $this->isFavorite = $isFavorite;
        $this->createdAt = $createdAt
            ? new DateTime($createdAt, new DateTimeZone(Config::get('app.timezone')))
            : new DateTime('now', new DateTimeZone(Config::get('app.timezone')));
    }


    /**
     * @param FormRequest $request
     * @return static
     * @throws Exception
     */
    public static function fromRequest(FormRequest $request): static
    {
        return new static(
            userId: App::auth()->id(),
            firstName: $request->post('first_name'),
            lastName: $request->post('last_name'),
            phone: $request->post('phone'),
            email: $request->post('email'),
            isFavorite: (bool) $request->post('is_favorite'),
            createdAt: $request->post('created_at'),
            id: (int) $request->post('id'),
        );
    }

    /**
     * @return int|null
     */
    public function getId(): ?int
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
     * @return bool
     */
    public function isFavorite(): bool
    {
        return $this->isFavorite;
    }

    /**
     * @return DateTime
     */
    public function getCreatedAt(): DateTime
    {
        return $this->createdAt;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'user_id' => $this->getUserId(),
            'first_name' => $this->getFirstName(),
            'last_name' => $this->getLastName(),
            'phone' => $this->getPhone(),
            'email' => $this->getEmail(),
            'is_favorite' => $this->isFavorite(),
            'created_at' => $this->getCreatedAt()->format('Y-m-d H:i:s'),
        ];
    }
}