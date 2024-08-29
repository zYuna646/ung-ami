<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateQuestionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'code' => 'required',
            'text' => 'required',
            'units' => 'required|array',
            'units.*' => 'exists:units,id',
        ];
    }

    public function messages(): array
    {
        return [
            'code.required' => 'Kode wajib diisi.',
            'text.required' => 'Pertanyaan wajib diisi.',
            'units.required' => 'Unit wajib diisi.',
        ];
    }
}
