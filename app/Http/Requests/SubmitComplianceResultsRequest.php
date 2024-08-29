<?php

namespace App\Http\Requests;

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
        if ($this->unit == 'Fakultas') {
            $this->model = Faculty::where('faculty_name', $this->faculty)->first();
        } elseif ($this->unit == 'Jurusan') {
            $this->model = Department::where('department_name', $this->department)->first();
        } elseif ($this->unit == 'Program Studi') {
            $this->model = Program::where('program_name', $this->program)->first();
        } else {
            $this->model = Unit::where('unit_name', $this->unit)->first();
        }
    }

    public function rules(): array
    {
        $rules = [
            'unit' => 'required'
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
            'unit.required' => 'Pilih Auditi'
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
