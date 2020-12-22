<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Validation\ValidationException;
use Illuminate\Http\Exceptions\HttpResponseException;

class BaseRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            //
        ];
    }

        /**
     * @param validator
     * @return json
     */

    protected function failedValidation(Validator $validator)
    {
        if ( $this->expectsJson() )
        {
            $validation = new ValidationException($validator);
            throw new HttpResponseException(
                response()->json($validation->errors(), 422)
            );
        }
    }
}
