<?php

declare(strict_types=1);

namespace App\Modules\Contact\Actions\Contact\Pages\CreatePage;

use App\Core\App;

/**
 * Class ShowCreationErrors
 *
 * @package App\Modules\Contact\Actions\Contact\Pages\CreatePage
 */
class ShowCreationErrors
{
    /**
     * @return bool
     */
    public function execute(): bool
    {
        $userId = App::auth()->id();
        $previousUri = App::request()->prevUri();
        $redirectFromStore = $previousUri === App::router()->uri('contact.store', ['userId' => $userId]);
        $redirectFromCreate = $previousUri === App::router()->uri('contact.create', ['userId' => $userId]);
        return $redirectFromStore || $redirectFromCreate;
    }
}