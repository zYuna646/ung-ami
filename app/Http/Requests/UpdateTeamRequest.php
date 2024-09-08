<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTeamRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'members' => 'required|array'
        ];
    }

    public function messages(): array
    {
        return [
            'members.required' => 'Anggota harus dipilih.'
        ];
    }
}
