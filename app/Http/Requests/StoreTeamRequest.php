<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTeamRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'chief_auditor_id' => 'required',
            'members' => 'required|array'
        ];
    }

    public function messages(): array
    {
        return [
            'chief_auditor_id.required' => 'Ketua harus dipilih.',
            'members.required' => 'Anggota harus dipilih.'
        ];
    }
}
