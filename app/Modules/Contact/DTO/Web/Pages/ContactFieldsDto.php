<?php

declare(strict_types=1);

namespace App\Modules\Contact\DTO\Web\Pages;

use App\Modules\Contact\Entities\Contact;

/**
 * Class ContactFieldsDto
 *
 * @package App\Modules\Contact\DTO\Web\Pages
 */
class ContactFieldsDto
{
    public function __construct()
    {
    }

    /**
     * @param Contact $contact
     * @return array
     */
    public function execute(Contact $contact): array
    {
        return [
            'id' => $contact->getId(),
            'first_name' => $contact->getFirstName(),
            'last_name' => $contact->getLastName(),
            'full_name' => $contact->getFullName(),
            'phone' => $contact->getPhone(),
            'email' => $contact->getEmail(),
            'created_at' => $contact->getCreatedAt()->format('Y-m-d H:i'),
        ];
    }
}