<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreMasterIndicatorRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'indicator' => 'required',
            'master_instrument_id' => 'required'
        ];
    }

    public function messages(): array
    {
        return [
            'indicator.required' => 'Indikator harus diisi.',
            'master_instrument_id.required' => 'Instrumen harus diisi.'
        ];
    }
}
