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
        return false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules(): array
{
    return [
        'santri_id' => 'required|exists:santris,id',
        'angkatan' => 'required|integer',
        'program' => 'required|integer',
        'tanggal_tagihan' => 'required|date',
        'tanggal_jatuh_tempo' => 'required|date',
        'nama_biaya' => 'required|string',
        'jumlah_biaya' => 'required|numeric|min:0',
        'denda' => 'nullable|numeric|min:0',
        'status' => 'required|in:baru,angsuran,lunas',
        'keterangan' => 'nullable|string',
    ];
}

}
