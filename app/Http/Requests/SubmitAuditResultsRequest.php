<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class SubmitAuditResultsRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $rules = [
            'area' => 'required'
        ];

        foreach ($this->instrument->questions as $question) {
            $rules["description.$question->id"] = 'required';
            $rules["amount_target.$question->id"] = 'required';
            $rules["existence.$question->id"] = 'required';
            $rules["compliance.$question->id"] = 'required';
        }

        return $rules;
    }

    public function messages(): array
    {
        $messages = [
            'area.required' => 'Pilih Auditi'
        ];

        foreach ($this->instrument->questions as $question) {
            $messages["description.$question->id.required"] = "Deskripsi Hasil Audit untuk pertanyaan '{$question->text}' harus diisi.";
            $messages["amount_target.$question->id.required"] = "Jumlah Target untuk pertanyaan '{$question->text}' harus diisi.";
            $messages["existence.$question->id.required"] = "Keberadaan untuk pertanyaan '{$question->text}' harus diisi.";
            $messages["compliance.$question->id.required"] = "Kesesuaian Standar untuk pertanyaan '{$question->text}' harus diisi.";
        }

        return $messages;
    }
}
