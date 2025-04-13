<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreTagihanRequest extends FormRequest
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
            'jumlah_biaya.*' => 'required',
            'angkatan'       => 'nullable|numeric',
            'program'        => 'nullable|string',
            'tanggal_tagihan'=> 'required|date',
            'tanggal_jatuh_tempo'=> 'required|date',
            'keterangan'    => 'nullable|string'
    ];
}

}
