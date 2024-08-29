<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMasterQuestionRequest extends FormRequest
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
        ];
    }

    public function messages(): array
    {
        return [
            'question.required' => 'Pertanyaan harus diisi.',
            'code.required' => 'Kode harus diisi.',
        ];
    }
}
