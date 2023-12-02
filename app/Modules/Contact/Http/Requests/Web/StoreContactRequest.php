<?php

declare(strict_types=1);

namespace App\Modules\Contact\Http\Requests\Web;

use App\Core\Request\FormRequest;
use App\Core\Request\Validation\Rules\Handlers\Exists;
use App\Core\Request\Validation\Rules\Handlers\IsBoolean;
use App\Core\Request\Validation\Rules\Handlers\IsEmail;
use App\Core\Request\Validation\Rules\Handlers\IsInteger;
use App\Core\Request\Validation\Rules\Handlers\IsString;
use App\Core\Request\Validation\Rules\Handlers\Max;
use App\Core\Request\Validation\Rules\Handlers\Min;
use App\Core\Request\Validation\Rules\Handlers\Regex;
use App\Core\Request\Validation\Rules\Handlers\Required;

/**
 * Class StoreContactRequest
 *
 * @package App\Modules\Contact\Http\Requests\Web
 */
class StoreContactRequest extends FormRequest
{
    const MIN_NAME_LENGTH = 3;
    const MAX_NAME_LENGTH = 255;

    /**
     * @return array
     */
    public function rules(): array
    {
        return [
            'user_id' => [
                Required::class,
                IsInteger::class,
                [Exists::class => ['users', 'id']],
            ],
            'first_name' => [
                Required::class,
                IsString::class,
                [Min::class => [self::MIN_NAME_LENGTH]],
                [Max::class => [self::MAX_NAME_LENGTH]]
            ],
            'last_name' => [
                Required::class,
                IsString::class,
                [Min::class => [self::MIN_NAME_LENGTH]],
                [Max::class => [self::MAX_NAME_LENGTH]]
            ],
            'phone' => [
                Required::class,
                IsString::class,
                [Regex::class => ["/^\+\d{12}$/"]],
            ],
            'email' => [
                Required::class,
                IsString::class,
                IsEmail::class,
            ],
//            'is_favorite' => [
//                Required::class,
//                IsBoolean::class,
//            ],
        ];
    }
}