<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePrescriptionRequest extends FormRequest
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
            'text' => 'string',
            'status' => 'prohibited',
            'doctor_id' => 'prohibited',
            'patient_id' => 'prohibited',
            'pharmacist_id' => 'prohibited',
        ];
    }
}
