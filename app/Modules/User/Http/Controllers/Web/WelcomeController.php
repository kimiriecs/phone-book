<?php declare(strict_types=1);

namespace App\Modules\User\Http\Controllers\Web;

use App\Core\Controller\WebController;
use App\Core\View\View;

/**
 * Class WelcomeController
 *
 * @package Modules\User\Http\Controllers\Web
 */
class WelcomeController extends WebController
{
    /**
     * @return void
     */
    public function index(): void
    {
        $content = 'welcome';
        View::render('base', compact('content'));
    }

    /**
     * @return void
     */
    public function topics(): void
    {
        $content = 'topics';
        View::render('base', compact('content'));
    }
}