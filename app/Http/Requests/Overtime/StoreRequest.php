<?php

namespace App\Http\Requests\Overtime;

use App\Http\Requests\CustomFormRequest;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreRequest extends CustomFormRequest
{
    public function rules(): array
    {
        return [
            'employee_id'   => ['required', 'integer', Rule::exists('employees', 'id')],
            'date'          => ['required', 'date', Rule::unique('overtimes', 'date')->where('employee_id', $this->employee_id)],
            'time_started'  => ['required', 'date_format:H:i', 'before:time_ended'],
            'time_ended'    => ['required', 'date_format:H:i', 'after:time_started'],

        ];
    }

    public function messages(): array
    {
        return [
            'required'      => ':Attribute harus diisi',
            'integer'       => ':Attribute harus berupa bilangan bulat',
            'exists'        => ':Attribute tidak memiliki id referensi pada tabel Employee',
            'unique'        => ':Attribute sudah terdaftar, tidak bisa mendaftarkan tanggal yang sama untuk satu employee',
            'date'          => ':Attribute tidak sesuai dengan format tanggal [Y-m-d]',
            'date_format'   => ':Attribute tidak sesuai dengan format [:format]',
            'before'        => ':Attribute tidak boleh lebih dari [:date]',
            'after'         => ':Attribute tidak boleh kurang dari [:date]',
        ];
    }
}
