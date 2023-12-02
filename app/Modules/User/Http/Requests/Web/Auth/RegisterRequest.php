<?php

declare(strict_types=1);

namespace Modules\User\Http\Requests\Web\Auth;

use App\Core\Request\Validation\Rules\Handlers\Confirmed;
use App\Core\Request\Validation\Rules\Handlers\IsString;
use App\Core\Request\Validation\Rules\Handlers\Max;
use App\Core\Request\Validation\Rules\Handlers\Min;
use App\Core\Request\Validation\Rules\Handlers\Password;
use App\Core\Request\Validation\Rules\Handlers\Required;

/**
 * Class LoginRequest
 *
 * @package Modules\User\Http\Requests\Web\Auth
 */
class RegisterRequest extends LoginRequest
{
    const MIN_PASSWORD_LENGTH = 8;
    const MAX_PASSWORD_LENGTH = 255;

    /**
     * @return array
     */
    public function rules(): array
    {
        $rules = parent::rules();

        $rules['password'] = [
            Required::class,
            IsString::class,
            [Min::class => [self::MIN_PASSWORD_LENGTH]],
            [Max::class => [self::MAX_PASSWORD_LENGTH]],
            [Password::class => [true, true, true]],
            [Confirmed::class => ['password_confirmation']]
        ];

        $rules['password_confirmation'] = [
            Required::class,
            IsString::class,
            [Min::class => [self::MIN_PASSWORD_LENGTH]],
            [Max::class => [self::MAX_PASSWORD_LENGTH]],
            [Password::class => [true, true, true]],
        ];

        return $rules;
    }
}