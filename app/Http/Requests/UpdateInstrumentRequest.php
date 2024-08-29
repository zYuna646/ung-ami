<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInstrumentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required',
            'units' => 'required',
            'faculties' => 'nullable',
            'departments' => 'nullable',
            'programs' => 'nullable',
        ];
    }

    public function messages(): array
    {
        return [
            'name.required' => 'Instrumen wajib diisi.',
            'units.required' => 'Unit wajib diisi.',
        ];
    }
}
