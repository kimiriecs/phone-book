<?php

declare(strict_types=1);

namespace App\Modules\Contact\Actions\Contact;

use App\Modules\Contact\Exceptions\ContactNotfoundException;
use Modules\Contact\Actions\Contact\GetContact;
use Modules\Contact\Interfaces\Repositories\ContactRepositoryInterface;

/**
 * Class DeleteContact
 *
 * @package App\Modules\Contact\Actions\Contact
 */
class DeleteContact
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
     * @param int $contactId
     * @return bool
     * @throws ContactNotfoundException
     */
    public function execute(int $contactId): bool
    {
        $contact = $this->getContact->execute($contactId);

        return $this->repository->delete($contact->getId());
    }
}