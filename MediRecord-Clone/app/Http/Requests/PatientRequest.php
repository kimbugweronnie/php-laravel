<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PatientRequest extends FormRequest
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
            'open_mrs_link'=> 'required|string',
            'facility_name'=> 'required|string',
            'gender'=> 'required|string',
            'patient_id'=> 'required|integer',
            'patient_name'=> 'required|string',
            'age_last_visit'=> 'required|string',
            'phone_number'=> 'required|string',
            'last_date'=> 'required|string',
            'duration'=> 'required|integer',
            'current_regimen'=> 'required|string',
            'expected_return'=> 'required|string',
            'days_over_due'=> 'required|string', 
        ];
    }
}
