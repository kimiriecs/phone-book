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
 * Class ContactSetIsFavoriteDto
 *
 * @package App\Modules\Contact\DTO\Web
 */
class ContactSetIsFavoriteDto
{
    protected ?int $id;
    protected bool $isFavorite;

    /**
     * @param int $id
     * @param bool $isFavorite
     * @throws Exception
     */
    public function __construct(
        int $id,
        bool $isFavorite,
    ) {
        $this->id = $id;
        $this->isFavorite = $isFavorite;
    }


    /**
     * @param FormRequest $request
     * @return static
     * @throws Exception
     */
    public static function fromRequest(FormRequest $request): static
    {
        return new static(
            id: (int) $request->routeParameter('contactId'),
            isFavorite: (bool) $request->post('is_favorite'),
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
     * @return bool
     */
    public function isFavorite(): bool
    {
        return $this->isFavorite;
    }

    /**
     * @return array
     */
    public function toArray(): array
    {
        return [
            'id' => $this->getId(),
            'is_favorite' => $this->isFavorite(),
        ];
    }
}