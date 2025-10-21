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
                // Tidak wajib mengisi semua field
                $rules["availability.$question->id"] = 'nullable';
                $rules["notes.$question->id"] = 'nullable';

                // Hanya validasi URL jika evidence diisi dan availability adalah 'Tersedia'
                if ($this->input("availability.$question->id") === 'Tersedia' && $this->has("evidence.$question->id") && !empty($this->input("evidence.$question->id"))) {
                    $rules["evidence.$question->id"] = 'nullable|url';
                }
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
                $messages["evidence.$question->id.required"] = "Bukti untuk pertanyaan '{$question->text}' harus diisi.";
                $messages["evidence.$question->id.url"] = "Bukti untuk pertanyaan '{$question->text}' harus berupa URL valid.";
            }
        }

        return $messages;
    }
}
