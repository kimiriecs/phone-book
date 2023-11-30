<?php

declare(strict_types=1);

namespace App\Modules\Contact\Actions\Contact\Pages\EditPage;

use App\Core\App;
use App\Core\View\View;
use App\Modules\Contact\DTO\Web\Pages\ContactEditPageDto;
use App\Modules\Contact\Entities\Contact;
use App\Modules\Contact\Exceptions\ContactNotfoundException;
use Modules\Contact\Actions\Contact\GetContact;

/**
 * Class RenderContactEditPage
 *
 * @package App\Modules\Contact\Actions\Contact\Pages\EditPage
 */
class RenderContactEditPage
{
    /**
     * @param GetContact $getContact
     * @param ShowEditionErrors $showErrors
     */
    public function __construct(
        protected GetContact $getContact,
        protected ShowEditionErrors $showErrors,
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
        $showErrors = $this->showErrors->execute($contactId);

        $content = 'components/contact/contact.base';
        $pageDto = new ContactEditPageDto(
            page: 'components/contact/contact.edit',
            fields: $contact->toArray(),
            errors: $showErrors ? App::errorBag()->all() : [],
            oldInput: $showErrors ? App::errorBag()->getOld() : [],
            includes: [],
        );

        View::render('base', compact('content', 'pageDto'));
    }
}