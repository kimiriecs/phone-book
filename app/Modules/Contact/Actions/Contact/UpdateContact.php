<?php

declare(strict_types=1);

namespace App\Modules\Contact\Actions\Contact;

use App\Core\Entity\Entity;
use App\Modules\Contact\DTO\Web\ContactDto;
use App\Modules\Contact\Entities\Contact;
use Modules\Contact\Actions\Contact\GetContact;
use Modules\Contact\Interfaces\Repositories\ContactRepositoryInterface;

/**
 * Class UpdateContact
 *
 * @package App\Modules\Contact\Actions\Contact
 */
class UpdateContact
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
     * @param ContactDto $dto
     * @return Contact|null
     */
    public function execute(ContactDto $dto): Contact|null
    {
        $data = array_filter($dto->toArray(), function ($field) {
            return $field !== 'id';
        }, ARRAY_FILTER_USE_KEY);

        /** @var Contact $contact */
        $contact = $this->repository->update($dto->getId(), $data);

        return $contact;
    }
}