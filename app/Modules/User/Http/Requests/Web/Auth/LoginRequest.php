<?php

declare(strict_types=1);

namespace Modules\User\Http\Requests\Web\Auth;

use App\Core\Request\FormRequest;
use App\Core\Request\Validation\Rules\Handlers\IsEmail;
use App\Core\Request\Validation\Rules\Handlers\IsString;
use App\Core\Request\Validation\Rules\Handlers\Required;

/**
 * Class LoginRequest
 *
 * @package Modules\User\Http\Requests\Web\Auth
 */
class LoginRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'email' => [
                Required::class,
                IsString::class,
                IsEmail::class,
            ],
            'password' => [
                Required::class,
                IsString::class
            ]
        ];
    }
}