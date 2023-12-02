<?php

declare(strict_types=1);

use App\Core\Middleware\Auth\Authenticated;
use App\Core\Middleware\Authorize\Authorized;
use App\Core\Router\Route\Route;
use App\Modules\Contact\Controllers\Web\ContactController;

Route::get('users/{userId}/contacts', [ContactController::class, 'index'])
    ->name('contact.index')
    ->middleware([Authenticated::class, Authorized::class]);

Route::get('users/{userId}/contacts/{contactId}', [ContactController::class, 'show'])
    ->name('contact.show')
    ->middleware([Authenticated::class, Authorized::class]);

Route::get('users/{userId}/contacts/create', [ContactController::class, 'create'])
    ->name('contact.create')
    ->middleware([Authenticated::class, Authorized::class]);

Route::post('users/{userId}/contacts/store', [ContactController::class, 'store'])
    ->name('contact.store')
    ->middleware([Authenticated::class, Authorized::class]);

Route::get('users/{userId}/contacts/{contactId}/edit', [ContactController::class, 'edit'])
    ->name('contact.edit')
    ->middleware([Authenticated::class, Authorized::class]);

Route::put('users/{userId}/contacts/{contactId}/update', [ContactController::class, 'update'])
    ->name('contact.update')
    ->middleware([Authenticated::class, Authorized::class]);

Route::patch('users/{userId}/contacts/{contactId}/isFavorite', [ContactController::class, 'setIsFavorite'])
    ->name('contact.favorite')
    ->middleware([Authenticated::class, Authorized::class]);

Route::delete('users/{userId}/contacts/{contactId}/delete', [ContactController::class, 'delete'])
    ->name('contact.delete')
    ->middleware([Authenticated::class, Authorized::class]);