<?php

declare(strict_types=1);

namespace App\Modules\Contact\Actions\Contact\Pages;

use App\Core\View\View;
use App\Modules\Contact\DTO\Web\Pages\ContactShowPageDto;
use App\Modules\Contact\Entities\Contact;
use App\Modules\Contact\Exceptions\ContactNotfoundException;
use Modules\Contact\Actions\Contact\GetContact;

/**
 * Class RenderContactShowPage
 *
 * @package App\Modules\Contact\Actions\Contact\Pages
 */
class RenderContactShowPage
{
    /**
     * @param GetContact $getContact
     */
    public function __construct(
        protected GetContact $getContact
    ) {
    }

    /**
     * @param int $contactId
     * @return void
     * @throws ContactNotfoundException
     */
    public function execute(int $contactId): void
    {
        /** @var Contact $contact */
        $contact = $this->getContact->execute($contactId);
        $content = 'components/contact/contact.base';
        $pageDto = new ContactShowPageDto(
            page: 'components/contact/contact.show',
            fields: $contact->toArray(),
            includes: [],
        );

        View::render('base', compact('content', 'pageDto'));
    }
}