<?php

namespace App\Http\Requests\Employee;

use App\Http\Requests\CustomFormRequest;
use Illuminate\Foundation\Http\FormRequest;

class StoreRequest extends CustomFormRequest
{
    public function rules(): array
    {
        return [
            'name' => ['required', 'string', 'min:2', 'unique:employees,name'],
            'salary' => ['required', 'integer', 'min:2000000' ,'max:10000000']
        ];
    }

    public function messages(): array
    {
        return [
            'required' => ':Attribute harus diisi',
            'string' => ':Attribute harus berupa string',
            'integer' => ':Attribute harus berupa bilangan bulat',
            'unique' => ':Attribute sudah terdaftar',
            'name.min' => ':Attribute harus memiliki minimum :min karakter',
            'min' => ':Attribute harus memiliki nilai minimum 2.000.000',
            'max' => ':Attribute harus memiliki nilai maksimum 10.000.000',
        ];
    }
}
