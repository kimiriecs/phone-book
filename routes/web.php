<?php

declare(strict_types=1);

use App\Core\Router\Route\Route;
use App\Modules\User\Http\Controllers\Web\WelcomeController;

Route::get('', [WelcomeController::class, 'index'])->name('welcome');

Route::get('topics', [WelcomeController::class, 'topics'])->name('topics');

require 'auth.php';