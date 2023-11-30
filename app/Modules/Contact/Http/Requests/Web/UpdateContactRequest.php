<?php

declare(strict_types=1);

namespace App\Modules\Contact\Http\Requests\Web;

use App\Core\Request\Validation\Rules\Handlers\Exists;
use App\Core\Request\Validation\Rules\Handlers\IsInteger;
use App\Core\Request\Validation\Rules\Handlers\Required;

/**
 * Class UpdateContactRequest
 *
 * @package App\Modules\Contact\Http\Requests\Web
 */
class UpdateContactRequest extends StoreContactRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        $rules = parent::rules();

        $rules['id'] = [
            Required::class,
            IsInteger::class,
            [Exists::class => ['contacts', 'id']],
        ];

        return $rules;
    }
}