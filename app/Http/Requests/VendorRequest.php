<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class VendorRequest extends FormRequest
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
            'nama' => 'required|string|max:255',
            'alamat' => 'required|string',
            'no_tlp' => 'required|string|max:20',
            'email' => 'required|email|max:255',
            'kategori_bisnis' => 'required|string|max:255',
            'catatan' => 'nullable|string|max:255',
            'npwp' => 'nullable|string|max:30',
        ];
    }
}
