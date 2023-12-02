<?php

declare(strict_types=1);

namespace App\Modules\Contact\Actions\Contact\Pages;

use App\Core\View\View;
use App\Modules\Contact\Actions\Contact\GetAllUserContacts;
use App\Modules\Contact\DTO\Web\Pages\ContactIndexPageDto;
use App\Modules\Contact\Entities\Contact;
use ReflectionException;

/**
 * Class RenderContactsIndexPage
 *
 * @package App\Modules\Contact\Actions\Contact\Pages
 */
class RenderContactsIndexPage
{
    /**
     * @param GetAllUserContacts $getAllUserContacts
     */
    public function __construct(
        protected GetAllUserContacts $getAllUserContacts
    ) {
    }

    /**
     * @param array|null $filter
     * @param array|null $sort
     * @return void
     * @throws ReflectionException
     */
    public function execute(?array $filter = [], ?array $sort = []): void
    {
        /** @var Contact[] $contacts */
        $contacts = $this->getAllUserContacts->execute($filter, $sort);

        $content = 'components/contact/contact.base';
        $pageDto = new ContactIndexPageDto(
            page: 'components/contact/contact.index',
            entities: $contacts,
            fields: Contact::fields(),
            includes: [],
        );

        View::render('base', compact('content', 'pageDto'));
    }
}