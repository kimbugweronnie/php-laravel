<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PatientUpdateRequest extends FormRequest
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
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'open_mrs_link'=> 'nullable|string',
            'facility_name'=> 'nullable|string',
            'gender'=> 'nullable|string',
            'patient_id'=> 'nullable|integer',
            'patient_name'=> 'nullable|string',
            'age_last_visit'=> 'nullable|string',
            'phone_number'=> 'nullable|string',
            'last_date'=> 'nullable|string',
            'duration'=> 'nullable|string',
            'current_regimen'=> 'nullable|string',
            'expected_return'=> 'nullable|string',
            'days_over_due'=> 'nullable|string', 
        ];
    }
}
