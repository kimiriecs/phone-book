<?php declare(strict_types=1);

namespace App\Modules\Contact\Controllers\Web;

use App\Core\App;
use App\Core\Controller\WebController;
use App\Core\Request\Request;
use App\Modules\Contact\Actions\Contact\DeleteContact;
use App\Modules\Contact\Actions\Contact\Pages\CreatePage\RenderContactCreatePage;
use App\Modules\Contact\Actions\Contact\Pages\EditPage\RenderContactEditPage;
use App\Modules\Contact\Actions\Contact\Pages\GetUrlWithSort;
use App\Modules\Contact\Actions\Contact\Pages\RenderContactShowPage;
use App\Modules\Contact\Actions\Contact\Pages\RenderContactsIndexPage;
use App\Modules\Contact\Actions\Contact\SetIsFavoriteContact;
use App\Modules\Contact\Actions\Contact\StoreContact;
use App\Modules\Contact\Actions\Contact\UpdateContact;
use App\Modules\Contact\DTO\Web\ContactDto;
use App\Modules\Contact\DTO\Web\ContactSetIsFavoriteDto;
use App\Modules\Contact\Exceptions\ContactNotfoundException;
use App\Modules\Contact\Http\Requests\Web\SetIsFavoriteContactRequest;
use App\Modules\Contact\Http\Requests\Web\StoreContactRequest;
use App\Modules\Contact\Http\Requests\Web\UpdateContactRequest;
use Exception;
use JetBrains\PhpStorm\NoReturn;
use ReflectionException;

/**
 * Class QuizUserController
 *
 * @package Modules\Quiz\Http\Controllers\Web
 */
class ContactController extends WebController
{
    /**
     * @param Request $request
     * @param RenderContactsIndexPage $action
     * @return void
     * @throws ReflectionException
     * @throws Exception
     */
    public function index(Request $request, RenderContactsIndexPage $action): void
    {
        App::session()->setCsrf();
        $filter = $request->get('filter');
        $sort = $request->get('sort');
        App::session()->set('contact.filter', $filter);
        App::session()->set('contact.sort', $sort);
        $action->execute($filter, $sort);
    }

    /**
     * @param int $contactId
     * @param RenderContactShowPage $action
     * @return void
     * @throws ContactNotfoundException
     */
    #[NoReturn]
    public function show(int $contactId, RenderContactShowPage $action): void
    {
        $action->execute($contactId);
    }

    /**
     * @param int $contactId
     * @param RenderContactEditPage $action
     * @return void
     * @throws ContactNotfoundException
     */
    #[NoReturn]
    public function edit(int $contactId, RenderContactEditPage $action): void
    {
        $action->execute($contactId);
    }

    /**
     * @param RenderContactCreatePage $action
     * @return void
     */
    #[NoReturn]
    public function create(RenderContactCreatePage $action): void
    {
        $action->execute();
    }

    /**
     * @param StoreContactRequest $request
     * @param StoreContact $action
     * @return void
     * @throws Exception
     */
    #[NoReturn]
    public function store(StoreContactRequest $request, StoreContact $action): void
    {
        $dto = ContactDto::fromRequest($request);
        $contact = $action->execute($dto);
        $data = [
            'data' => $contact->toArray(),
            'redirect_url' => App::router()->uri('contact.index', ['userId' => App::auth()->id()])
        ];

        App::response()->json($data);
    }

    /**
     * @param UpdateContactRequest $request
     * @param UpdateContact $action
     * @return void
     * @throws Exception
     */
    #[NoReturn]
    public function update(UpdateContactRequest $request, UpdateContact $action): void
    {
        $dto = ContactDto::fromRequest($request);
        $action->execute($dto);
        App::response()->redirect(App::router()->uri('contact.index', ['userId' => App::auth()->id()]));
    }

    /**
     * @param int $contactId
     * @param DeleteContact $action
     * @param GetUrlWithSort $getRedirectUri
     * @return void
     * @throws ContactNotfoundException
     * @throws Exception
     */
    #[NoReturn]
    public function delete(int $contactId, DeleteContact $action, GetUrlWithSort $getRedirectUri): void
    {
        $action->execute($contactId);
        App::response()->redirect($getRedirectUri->execute());
    }

    /**
     * @param SetIsFavoriteContactRequest $request
     * @param SetIsFavoriteContact $action
     * @param GetUrlWithSort $getRedirectUri
     * @return void
     * @throws Exception
     */
    #[NoReturn]
    public function setIsFavorite(SetIsFavoriteContactRequest $request, SetIsFavoriteContact $action, GetUrlWithSort $getRedirectUri): void
    {
        $dto = ContactSetIsFavoriteDto::fromRequest($request);
        $action->execute($dto);
        App::response()->redirect($getRedirectUri->execute());
    }
}