<?php

declare(strict_types=1);

namespace App\Modules\User\Http\Controllers\Web;

use App\Core\View\View;

/**
 * Class DashboardController
 *
 * @package App\Modules\User\Http\Controllers\Web
 */
class DashboardController
{
    /**
     * @return void
     */
    public function index(): void
    {
        $content = 'dashboard';
        View::render('base', compact('content'));
    }
}