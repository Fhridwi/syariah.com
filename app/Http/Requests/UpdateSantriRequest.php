<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSantriRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'wali_id' => 'nullable|exists:users,id',
            'wali_status' => 'nullable|string|max:50',
            'nama' => 'required|string|max:255',
            'nis' => 'required|string|max:50|unique:santris,nis,' . $this->id,
            'program' => 'required|string|max:100',
            'angkatan' => 'required|string|max:10',
            'foto' => 'nullable|image|mimes:jpg,jpeg,png|max:5000',
        ];
    }
}
