<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class CustomFormRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    protected function failedValidation(Validator $validator)
    {
        $errors = new \stdClass();
        foreach ($validator->errors()->messages() as $key => $value) {
            $errors->$key = $value[0];
        }

        throw new HttpResponseException(
            resJson([
                'errors' => $errors
            ], 422)
        );
    }
}
