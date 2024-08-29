<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreInstrumentRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'master_instrument_id' => 'required',
            'periode_id' => 'required',
            'units' => 'required',
        ];
    }

    public function messages(): array
    {
        return [
            'periode_id.required' => 'Periode wajib dipilih.',
            'master_instrument_id.required' => 'Instrumen wajib diisi.',
            'units.required' => 'Unit wajib diisi.',
        ];
    }
}
