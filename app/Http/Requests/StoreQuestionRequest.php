<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreQuestionRequest extends FormRequest
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
            'indicator_id' => 'required',
            'units' => 'required|array',
            'units.*' => 'exists:units,id',
            'desc' => 'nullable',
        ];
    }

    public function messages(): array
    {
        return [
            'code.required' => 'Kode wajib diisi.',
            'text.required' => 'Pertanyaan wajib diisi.',
            'indicator_id.required' => 'Indikator wajib diisi.',
            'units.required' => 'Unit wajib diisi.',
        ];
    }
}
