<?php

declare(strict_types=1);

namespace App\Modules\Contact\Actions\Contact\Pages\CreatePage;

use App\Core\App;
use App\Core\View\View;
use App\Modules\Contact\DTO\Web\Pages\ContactCreatePageDto;
use App\Modules\Contact\Entities\Contact;

/**
 * Class RenderContactCreatePage
 *
 * @package App\Modules\Contact\Actions\Contact\Pages\CreatePage
 */
class RenderContactCreatePage
{
    /**
     * @param ShowCreationErrors $showErrors
     */
    public function __construct(
        protected ShowCreationErrors $showErrors
    ) {
    }

    /**
     * @return void
     */
    public function execute(): void
    {
        $showErrors = $this->showErrors->execute();
        $content = 'components/contact/contact.base';
        $pageDto = new ContactCreatePageDto(
            page: 'components/contact/contact.create',
            fields: Contact::fields(),
            errors: $showErrors ? App::errorBag()->all() : [],
            oldInput: $showErrors ? App::errorBag()->getOld() : [],
            includes: [],
        );

        View::render('base', compact('content', 'pageDto'));
    }
}