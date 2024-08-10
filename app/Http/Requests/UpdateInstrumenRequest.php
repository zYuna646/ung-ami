<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateInstrumenRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name' => 'required',
            'standar_id' => 'required',
            'tipe' => 'required',
            'periode' => 'required|numeric|min:1998|max:2099',
            'ketua_id' => 'required'
        ];
    }
}
