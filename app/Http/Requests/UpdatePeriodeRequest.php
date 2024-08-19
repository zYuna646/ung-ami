<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdatePeriodeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'year' => 'required|numeric|min:1998|max:2099',
            'start_date' => 'required|date',
            'end_date' => 'required|date',
            'standard_id' => 'required',
            'units' => 'required',
            'tipe' => 'required',
            'chief_auditor_id' => 'required'
        ];
    }
}
