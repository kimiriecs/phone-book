<?php declare(strict_types=1);

namespace App\Modules\User\Actions\Web;

use App\Core\Response\HttpStatusCodeEnum;
use App\Core\View\View;

/**
 * Class RenderErrorPage
 *
 * @package Modules\User\Actions
 */
class RenderErrorPage
{
    /**
     * @param HttpStatusCodeEnum $errorCode
     * @return void
     */
    public function execute(HttpStatusCodeEnum $errorCode): void
    {
        $message = $errorCode::getMessage($errorCode);
        $content = 'error-page';
        View::render('base', compact('content', 'message'));
    }
}