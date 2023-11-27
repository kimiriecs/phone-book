<?php

declare(strict_types=1);

use App\Core\Middleware\Auth\Authenticated;
use App\Core\Router\Route\Route;
use App\Modules\User\Http\Controllers\Web\DashboardController;
use App\Modules\User\Http\Controllers\Web\WelcomeController;


Route::get('', [WelcomeController::class, 'index'])->name('welcome');

Route::get('topics', [WelcomeController::class, 'topics'])->name('topics');

Route::get('users/{userId}/dashboard', [DashboardController::class, 'index'])
    ->name('dashboard')
    ->middleware(Authenticated::class);

require 'error.php';
require 'auth.php';