<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateMasterIndicatorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'indicator' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'indicator.required' => 'Indikator harus diisi.',
        ];
    }
}
