<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateDiseaseRecordRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return $this->user()->hasFilledRecords();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules()
    {
        return [
            "user_id" => 'prohibited',
            "covid_19" => 'boolean',
            "respiratory" => 'boolean',
            "infectious" => 'boolean',
            "vascular" => 'boolean',
            "cancer" => 'boolean',
            "imuloical" => 'boolean',
            "diabetes" => 'boolean',
            "dangerous_area" => 'boolean',
            "pet" => "boolean",
        ];
    }
}
