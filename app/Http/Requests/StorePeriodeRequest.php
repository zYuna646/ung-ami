<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StorePeriodeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'periode_name' => 'required',
            'year' => 'required|numeric|min:1998|max:2099',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            // 'standard_id' => 'required',
            'tipe' => 'required',
            'code' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'periode_name.required' => 'Nama Periode wajib diisi.',
            'year.required' => 'Tahun wajib diisi.',
            'year.numeric' => 'Tahun harus berupa angka.',
            'year.min' => 'Tahun minimal adalah 1998.',
            'year.max' => 'Tahun maksimal adalah 2099.',
            'start_date.required' => 'Tanggal mulai wajib diisi.',
            'start_date.date' => 'Tanggal mulai harus berupa format tanggal yang valid.',
            'end_date.required' => 'Tanggal selesai wajib diisi.',
            'end_date.date' => 'Tanggal selesai harus berupa format tanggal yang valid.',
            // 'standard_id.required' => 'Standar wajib dipilih.',
            'tipe.required' => 'Tipe wajib diisi.',
            'code.required' => 'Kode dokumen wajib diisi.',
        ];
    }
}
