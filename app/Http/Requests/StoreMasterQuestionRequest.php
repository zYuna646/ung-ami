<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMasterQuestionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'code' => 'required',
            'question' => 'required',
            'master_indicator_id' => 'required',
            'desc' => 'nullable'
        ];
    }

    public function messages(): array
    {
        return [
            'question.required' => 'Pertanyaan harus diisi.',
            'code.required' => 'Kode harus diisi.',
            'master_indicator_id.required' => 'Instrumen harus diisi.'
        ];
    }
}
