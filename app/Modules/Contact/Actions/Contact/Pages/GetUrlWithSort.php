<?php

declare(strict_types=1);

namespace App\Modules\Contact\Actions\Contact\Pages;

use App\Core\App;
use Exception;

/**
 * Class GetUrlWithSort
 *
 * @package App\Modules\Contact\Actions\Contact\Pages
 */
class GetUrlWithSort
{
    /**
     * @return string
     * @throws Exception
     */
    public function execute(): string
    {
        $query = ['sort' => App::session()->get('contact.sort')];
        $queryString = isset($query['sort']) ? http_build_query($query) : '';

        return App::router()->uri('contact.index', ['userId' => App::auth()->id()]) . '?' . $queryString;
    }
}