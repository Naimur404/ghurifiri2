<?php

namespace Botble\Member\Http\Requests;

use Botble\Base\Facades\BaseHelper;
use Botble\Support\Http\Requests\Request;

class SettingRequest extends Request
{
    public function rules(): array
    {
        return [
            'first_name' => ['required', 'string', 'max:120'],
            'last_name' => ['required', 'string', 'max:120'],
            'phone' => 'nullable|' . BaseHelper::getPhoneValidationRule(),
            'dob' => ['nullable', 'date', 'max:20'],
        ];
    }
}
