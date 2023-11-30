<?php

declare(strict_types=1);

namespace Modules\Contact\Actions\Contact;

use App\Core\Entity\Entity;
use App\Modules\Contact\Entities\Contact;
use App\Modules\Contact\Exceptions\ContactNotfoundException;
use Modules\Contact\Interfaces\Repositories\ContactRepositoryInterface;

/**
 * Class GetContact
 *
 * @package Modules\Contact\Actions\Contact
 */
class GetContact
{
    /**
     * @param ContactRepositoryInterface $repository
     */
    public function __construct(
        protected ContactRepositoryInterface $repository
    ) {
    }

    /**
     * @param int $contactId
     * @return Entity|null
     * @throws ContactNotfoundException
     */
    public function execute(int $contactId): ?Entity
    {
        $contact = $this->repository->findById($contactId);

        if (! $contact instanceof Contact) {
            throw new ContactNotfoundException("Contact not found", 404);
        }

        return $contact;
    }
}