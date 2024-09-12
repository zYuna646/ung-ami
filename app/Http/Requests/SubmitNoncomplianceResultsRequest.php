<?php

namespace App\Http\Requests;

use App\Helpers\ModelHelper;
use App\Models\Department;
use App\Models\Faculty;
use App\Models\Program;
use App\Models\Unit;
use Illuminate\Foundation\Http\FormRequest;

class SubmitNoncomplianceResultsRequest extends FormRequest
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
            if ($auditResult && $auditResult->compliance == 'Tidak Sesuai') {
                $rules["description.$question->id"] = 'required';
                $rules["category.$question->id"] = 'required';
                $rules["barriers.$question->id"] = 'required';
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
            if ($auditResult && $auditResult->compliance == 'Tidak Sesuai') {
                $messages["description.$question->id.required"] = "Deskripsi Hasil Audit untuk pertanyaan '{$question->text}' harus diisi.";
                $messages["category.$question->id.required"] = "Kategori Temuan Audit untuk pertanyaan '{$question->text}' harus diisi.";
                $messages["barriers.$question->id.required"] = "Faktor Penghambat untuk pertanyaan '{$question->text}' harus diisi.";
            }
        }

        return $messages;
    }
}
