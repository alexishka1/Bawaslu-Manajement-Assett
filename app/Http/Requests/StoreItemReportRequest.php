<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreItemReportRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->check();
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'kondisi_aktual' => 'required|in:tersedia,terpakai,servis,rusak,hilang',
            'foto_bukti' => 'required|image|mimes:jpeg,png,jpg,webp|max:5120',
            'catatan' => 'nullable|string|max:1000',
        ];
    }

    /**
     * Custom validation messages in Indonesian.
     */
    public function messages(): array
    {
        return [
            'kondisi_aktual.required' => 'Kondisi aktual barang wajib dipilih.',
            'kondisi_aktual.in' => 'Kondisi barang harus valid (tersedia, terpakai, servis, rusak, hilang).',
            'foto_bukti.required' => 'Foto bukti kondisi fisik aset wajib diunggah.',
            'foto_bukti.image' => 'File bukti harus berupa gambar.',
            'foto_bukti.max' => 'Ukuran foto bukti maksimal adalah 5MB.',
        ];
    }
}
