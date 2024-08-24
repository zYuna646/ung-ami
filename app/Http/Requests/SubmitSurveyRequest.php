<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubmitSurveyRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [];

        foreach ($this->instrument->questions as $question) {
            if ($this->user()->can('view', $question)) {
                $rules["availability.$question->id"] = 'required';
                $rules["notes.$question->id"] = 'required';
            }
        }

        return $rules;
    }

    public function messages(): array
    {
        $messages = [];

        foreach ($this->instrument->questions as $question) {
            if ($this->user()->can('view', $question)) {
                $messages["availability.$question->id.required"] = "Ketersediaan dokumen untuk pertanyaan '{$question->text}' harus diisi.";
                $messages["notes.$question->id.required"] = "Catatan untuk pertanyaan '{$question->text}' harus diisi.";
            }
        }

        return $messages;
    }
}
