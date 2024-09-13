<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CompleteAuditRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'meeting_report' => 'required|file|mimes:pdf|max:10240',
            'activity_evidence' => 'required|file|mimes:jpg,jpeg,png|max:10240',
        ];
    }

    public function messages(): array
    {
        return [
            'meeting_report.required' => 'Berita Acara harus diunggah.',
            'meeting_report.file' => 'Berita Acara harus berupa file yang valid.',
            'meeting_report.mimes' => 'Berita Acara harus berupa file dengan format: pdf.',
            'meeting_report.max' => 'Ukuran Berita Acara tidak boleh lebih dari 10MB.',
            'activity_evidence.required' => 'Bukti Kegiatan harus diunggah.',
            'activity_evidence.file' => 'Bukti Kegiatan harus berupa file yang valid.',
            'activity_evidence.mimes' => 'Bukti Kegiatan harus berupa file dengan format: jpg, jpeg, atau png.',
            'activity_evidence.max' => 'Ukuran Bukti Kegiatan tidak boleh lebih dari 10MB.',
        ];
    }
}
