<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePatientRequest extends FormRequest
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
            'covid_19' => 'boolean',
            'respiratory' => 'boolean',
            'infectious' => 'boolean',
            'vascular' => 'boolean',
            'cancer' => 'boolean',
            'imuloical' => 'boolean',
            'diabetes' => 'boolean',
            'dangerous_area' => 'boolean',
            'pet' => 'boolean',
            'med_staff' => 'boolean',
        ];
    }
}
