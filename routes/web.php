<?php

declare(strict_types=1);

use App\Core\Router\Route\Route;

Route::get('', function () {
    phpinfo();
})->name('test');