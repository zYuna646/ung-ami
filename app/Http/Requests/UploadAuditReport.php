<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UploadAuditReport extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'meeting_report' => 'required|image|mimes:jpeg,png,jpg,gif,svg|max:2048',
            'activity_evidences' => 'required|array',
            'activity_evidences.*' => 'image|mimes:jpeg,png,jpg,gif,svg|max:2048',
        ];
    }

    public function messages(): array
    {
        return [
            'meeting_report.required' => 'Berita Acara wajib diunggah.',
            'meeting_report.image' => 'Berita Acara harus berupa file gambar.',
            'meeting_report.mimes' => 'Berita Acara harus berformat jpeg, png, jpg, gif, atau svg.',
            'meeting_report.max' => 'Ukuran Berita Acara tidak boleh lebih dari 2MB.',

            'activity_evidences.required' => 'Bukti Kegiatan wajib diunggah.',
            'activity_evidences.array' => 'Bukti Kegiatan harus berupa array.',
            'activity_evidences.*.image' => 'Setiap Bukti Kegiatan harus berupa file gambar.',
            'activity_evidences.*.mimes' => 'Setiap Bukti Kegiatan harus berformat jpeg, png, jpg, gif, atau svg.',
            'activity_evidences.*.max' => 'Ukuran setiap Bukti Kegiatan tidak boleh lebih dari 2MB.',
        ];
    }
}
