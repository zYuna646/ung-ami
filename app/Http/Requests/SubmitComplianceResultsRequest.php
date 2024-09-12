<?php

namespace App\Http\Requests;

use App\Helpers\ModelHelper;
use App\Models\Department;
use App\Models\Faculty;
use App\Models\Program;
use App\Models\Unit;
use Illuminate\Foundation\Http\FormRequest;

class SubmitComplianceResultsRequest extends FormRequest
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
                $rules["description.$question->id"] = 'required';
                $rules["success_factors.$question->id"] = 'required';
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
                $messages["description.$question->id.required"] = "Deskripsi Hasil Audit untuk pertanyaan '{$question->text}' harus diisi.";
                $messages["success_factors.$question->id.required"] = "Faktor Keberhasilan untuk pertanyaan '{$question->text}' harus diisi.";
            }
        }

        return $messages;
    }
}
