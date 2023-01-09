<?php

namespace App\Http\Requests\Setting;

use App\Http\Requests\CustomFormRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateRequest extends CustomFormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'key'   => ['in:overtime_method'],
            'value' => [
                Rule::exists('references', 'id')
                ->where('code', 'overtime_method')
            ]
        ];
    }

    public function messages(): array
    {
        return [
            'in'        => ':Attribute hanya boleh diisi dengan ":values"',
            'exists'    => ':Attribute tidak memiliki id referensi dengan code "overtime_method"'
        ];
    }
}
