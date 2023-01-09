<?php

namespace App\Http\Requests\Overtime;

use App\Http\Requests\CustomFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class CalculateRequest extends CustomFormRequest
{
    public function rules(): array
    {
        return [
            'month' => 'date_format:Y-m'
        ];
    }

    public function messages(): array
    {
        return [
            'date_format' => ':Attribute tidak sesuai dengan format [:format]',
        ];
    }
}
