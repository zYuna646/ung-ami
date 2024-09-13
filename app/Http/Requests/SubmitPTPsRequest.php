<?php

namespace App\Http\Requests;

use App\Helpers\ModelHelper;
use Illuminate\Foundation\Http\FormRequest;

class SubmitPTPsRequest extends FormRequest
{
    protected $model;

    public function authorize(): bool
    {
        return true;
    }

    public function prepareForValidation()
    {
        $this->model = ModelHelper::getModelByRequest($this);
    }

    public function rules(): array
    {
        $rules = [
            'area' => 'required'
        ];

        foreach ($this->instrument->questions as $question) {
            $auditResult = $this->model->auditResults->firstWhere('question_id', $question->id);
            if ($auditResult && $auditResult->compliance == 'Sesuai') {
                $rules["recommendations.$question->id"] = 'required';
                $rules["improvement_plan.$question->id"] = 'required';
                $rules["completion_schedule.$question->id"] = 'required';
                $rules["responsible_party.$question->id"] = 'required';
            }
        }

        return $rules;
    }

    public function messages(): array
    {
        $messages = [
            'area.required' => 'Pilih Auditi'
        ];

        foreach ($this->instrument->questions as $question) {
            $auditResult = $this->model->auditResults->firstWhere('question_id', $question->id);
            if ($auditResult && $auditResult->compliance == 'Sesuai') {
                $messages["recommendations.$question->id.required"] = "Rekomendasi untuk pertanyaan '{$question->text}' harus diisi.";
                $messages["improvement_plan.$question->id.required"] = "Rencana Peningkatan untuk pertanyaan '{$question->text}' harus diisi.";
                $messages["completion_schedule.$question->id.required"] = "Jadwal Penyelesaian untuk pertanyaan '{$question->text}' harus diisi.";
                $messages["responsible_party.$question->id.required"] = "Pihak yang Bertanggungjawab untuk pertanyaan '{$question->text}' harus diisi.";
            }
        }

        return $messages;
    }
}
