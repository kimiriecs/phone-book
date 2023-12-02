<?php

declare(strict_types=1);

use App\Core\Helpers\Str;
use App\Core\Response\HttpStatusCodeEnum;
use App\Core\Router\Route\Route;
use App\Modules\User\Http\Controllers\Web\ErrorPageController;

foreach (HttpStatusCodeEnum::cases() as $case) {
    $uri = $case->value;
    $name = Str::camel($case->name);
    Route::get("$uri", [ErrorPageController::class, $name])->name($name);
}