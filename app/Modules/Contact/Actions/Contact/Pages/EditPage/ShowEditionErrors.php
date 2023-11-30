<?php

declare(strict_types=1);

namespace App\Modules\Contact\Actions\Contact\Pages\EditPage;

use App\Core\App;

/**
 * Class ShowEditionErrors
 *
 * @package App\Modules\Contact\Actions\Contact\Pages\EditPage
 */
class ShowEditionErrors
{
    /**
     * @param int $contactId
     * @return bool
     */
    public function execute(int $contactId): bool
    {
        $userId = App::auth()->id();
        $uriParameters = [
            'userId' => $userId,
            'contactId' => $contactId
        ];

        $previousUri = App::request()->prevUri();
        $redirectFromUpdate = $previousUri === App::router()->uri('contact.update', $uriParameters);
        $redirectFromEdit = $previousUri === App::router()->uri('contact.edit', $uriParameters);

        return $redirectFromUpdate || $redirectFromEdit;
    }
}