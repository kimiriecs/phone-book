<?php

declare(strict_types=1);

namespace App\Modules\Contact\Http\Requests\Web;

use App\Core\Request\FormRequest;

/**
 * Class SetIsFavoriteContactRequest
 *
 * @package App\Modules\Contact\Http\Requests\Web
 */
class SetIsFavoriteContactRequest extends FormRequest
{
    /**
     * @return array
     */
    public function rules(): array
    {
        return [];
    }
}