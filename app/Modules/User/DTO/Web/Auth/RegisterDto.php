<?php declare(strict_types=1);

namespace Modules\User\DTO\Web\Auth;

use App\Core\Helpers\Config;
use DateTime;
use DateTimeZone;
use Exception;
use Modules\User\Http\Requests\Web\Auth\RegisterRequest;

/**
 * Class RegisterDto
 *
 * @package Modules\User\DTO\Web\Auth
 */
class RegisterDto
{
    /**
     * @var DateTime|null $createdAt
     */
    protected ?DateTime $createdAt;

    /**
     * @param string $email
     * @param string $password
     * @param string|null $createdAt
     * @throws Exception
     */
    public function __construct(
        protected string $email,
        protected string $password,
        ?string $createdAt = null,
    ) {
        $this->password = password_hash($password, PASSWORD_DEFAULT);
        $this->createdAt = $createdAt
            ? new DateTime($createdAt, new DateTimeZone(Config::get('app.timezone')))
            : new DateTime('now', new DateTimeZone(Config::get('app.timezone')));
    }


    /**
     * @param RegisterRequest $request
     * @return RegisterDto
     * @throws Exception
     */
    public static function fromRequest(RegisterRequest $request): RegisterDto
    {
        return new static(
            email: $request->post('email'),
            password: $request->post('password'),
            createdAt: $request->post('created_at')
        );
    }

    /**
     * @param array $data
     * @return RegisterDto
     * @throws Exception
     */
    public static function fromArray(array $data): RegisterDto
    {
        return new static(
            email: $data['email'] ?? null,
            password: $data['password'] ?? null,
            createdAt: $data['created_at'] ?? null,
        );
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'email' => $this->getEmail(),
            'password' => $this->getPassword(),
            'created_at' => $this->getCreatedAt()->format('Y-m-d H:i:s'),
        ];
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
     * @return DateTime|null
     */
    public function getCreatedAt(): ?DateTime
    {
        return $this->createdAt;
    }
}