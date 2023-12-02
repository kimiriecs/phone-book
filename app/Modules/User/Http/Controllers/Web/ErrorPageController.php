<?php declare(strict_types=1);

namespace App\Modules\User\Http\Controllers\Web;

use App\Core\Controller\WebController;
use App\Core\Response\HttpStatusCodeEnum;
use App\Modules\User\Actions\Web\RenderErrorPage;

/**
 * Class HomeController
 *
 * @package Modules\User\Http\Controllers\Web
 */
class ErrorPageController extends WebController
{
    /**
     * @param RenderErrorPage $action
     * @return void
     */
    public function forbidden(RenderErrorPage $action): void
    {
        $action->execute(HttpStatusCodeEnum::FORBIDDEN);
    }

    /**
     * @param RenderErrorPage $action
     * @return void
     */
    public function notFound(RenderErrorPage $action): void
    {
        $action->execute(HttpStatusCodeEnum::NOT_FOUND);
    }

    /**
     * @param RenderErrorPage $action
     * @return void
     */
    public function unauthorized(RenderErrorPage $action): void
    {
        $action->execute(HttpStatusCodeEnum::UNAUTHORIZED);
    }

    /**
     * @param RenderErrorPage $action
     * @return void
     */
    public function internalServerError(RenderErrorPage $action): void
    {
        $action->execute(HttpStatusCodeEnum::INTERNAL_SERVER_ERROR);
    }

    /**
     * @param RenderErrorPage $action
     * @return void
     */
    public function unprocessable(RenderErrorPage $action): void
    {
        $action->execute(HttpStatusCodeEnum::UNPROCESSABLE);
    }

    /**
     * @param RenderErrorPage $action
     * @return void
     */
    public function unavailable(RenderErrorPage $action): void
    {
        $action->execute(HttpStatusCodeEnum::UNAVAILABLE);
    }
}