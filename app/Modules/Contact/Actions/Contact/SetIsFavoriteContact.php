<?php

declare(strict_types=1);

namespace App\Modules\Contact\Actions\Contact;

use App\Modules\Contact\DTO\Web\ContactSetIsFavoriteDto;
use App\Modules\Contact\Entities\Contact;
use Modules\Contact\Actions\Contact\GetContact;
use Modules\Contact\Interfaces\Repositories\ContactRepositoryInterface;

/**
 * Class SetIsFavoriteContact
 *
 * @package App\Modules\Contact\Actions\Contact
 */
class SetIsFavoriteContact
{
    /**
     * @param GetContact $getContact
     * @param ContactRepositoryInterface $repository
     */
    public function __construct(
        protected GetContact $getContact,
        protected ContactRepositoryInterface $repository
    ) {
    }

    /**
     * @param ContactSetIsFavoriteDto $dto
     * @return Contact|null
     */
    public function execute(ContactSetIsFavoriteDto $dto): Contact|null
    {
//        Arr::except($dto->toArray(), ['id']);
        $data = array_filter($dto->toArray(), function ($field) {
            return $field !== 'id';
        }, ARRAY_FILTER_USE_KEY);

        /** @var Contact $contact */
        $contact = $this->repository->update($dto->getId(), $data);

        return $contact;
    }
}