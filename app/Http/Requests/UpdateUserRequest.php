<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            'phone' => 'prohibited',
            'role' => 'prohibited',
            'email' => 'email:rfc,dns',
            'fname' => 'required|regex:/^[\pL\s\-]+$/u',
            'lname' => 'required|regex:/^[\pL\s\-]+$/u',
            'address' => 'string|nullable',
            'age' => 'numeric|between:0,120',
            'gender' => 'string|nullable',
        ];
    }
}
