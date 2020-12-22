<?php

namespace App\Http\Requests\ReliefGood;

use App\Http\Requests\BaseRequest;
use Illuminate\Support\Facades\Auth;

class UpdateReliefGood extends BaseRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return Auth::guard('web')->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'category' => ['required'],
            'name' => ['required', 'string'],
            'quantity' => ['required', 'integer', 'min:1'],
            'to' => ['required', 'string']
        ];
    }

}
