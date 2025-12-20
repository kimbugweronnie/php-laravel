<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class ActivityRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */

    public function rules(): array
    {
        return [
            'activity_name' => 'required|string',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'is_recurring' => 'required',
            'recurring_frequency' => 'required',
            'has_report' => 'required'
        ];
    }
}
