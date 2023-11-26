<?php

declare(strict_types=1);

use App\Core\Middleware\Auth\Authenticated;
use App\Core\Middleware\Auth\UnAuthenticated;
use App\Core\Router\Route\Route;
use Modules\User\Http\Controllers\Web\Auth\LoginController;
use Modules\User\Http\Controllers\Web\Auth\RegisterController;

Route::get('register/show', [RegisterController::class, 'showRegister'])
    ->name('register.show')
    ->middleware(UnAuthenticated::class);

Route::post('register', [RegisterController::class, 'register'])
    ->name('register')
    ->middleware(UnAuthenticated::class);

Route::get('login/show', [LoginController::class, 'showLogin'])
    ->name('login.show')
    ->middleware(UnAuthenticated::class);

Route::post('login', [LoginController::class, 'login'])
    ->name('login')
    ->middleware(UnAuthenticated::class);

Route::post('logout', [LoginController::class, 'logout'])
    ->name('logout')
    ->middleware(Authenticated::class);