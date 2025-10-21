<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UserRequest extends FormRequest
{
    
    public function authorize()
    {
        return true;
    }

   
    public function rules()
    {
        return [
            'system_id' => 'nullable|string',
            'username' => 'nullable|string|unique:users',
            'email' => 'nullable|email|unique:users',
            'password' => 'nullable|string',
            'salt' => 'nullable|string',
            'secret_question' => 'nullable|string',
            'secret_answer' => 'nullable|string',

            'creator' => 'nullable|integer',
            'changed_by' => 'nullable|integer',
            'person_id' => 'nullable|integer',
            'retired_by' => 'nullable|integer',

            'date_created'=> 'nullable|string',
            'date_changed' => 'nullable|string',
            'retired' => 'nullable|boolean',
           
            'date_retired' => 'nullable|string',
            'retire_reason' => 'nullable|string',
            'uuid' => 'nullable|string',
            'role' => 'required|string'
        ];
    }
}
