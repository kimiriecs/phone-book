<?php

declare(strict_types=1);

namespace App\Core\Request;

use App\Core\App;
use App\Core\Exceptions\FailedValidationException;
use JetBrains\PhpStorm\NoReturn;

/**
 * Class ValidationErrorHandler
 *
 * @package App\Core\Request
 */
class ValidationErrorHandler
{
    /**
     * @param FailedValidationException $exception
     * @return void
     */
    #[NoReturn]
    public static function handle(FailedValidationException $exception): void
    {
        $message = $exception->getMessage();
        $errors = App::errorBag()->all();
        App::log()->error($message, ['errors' => $errors]);

        if (App::request()->isXRH()) {
            App::response()->json([
                'message' => $message,
                'errors' => $errors
            ], $exception->getCode());
        }

        $uri = App::request()->prevUri();
        App::response()->redirect($uri);
    }
}