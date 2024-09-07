<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreAuditeeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed',
        ];

        switch ($this->type) {
            case 'unit':
                $rules['unit_id'] = 'required';
                break;
            case 'faculty':
                $rules['faculty_id'] = 'required';
                break;
            case 'program':
                $rules['program_id'] = 'required';
                break;
        }

        return $rules;
    }
}
