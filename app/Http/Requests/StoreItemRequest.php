<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class StoreItemRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return auth()->user()?->isAdmin() ?? false;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'kode_bmn' => 'required|string|unique:items,kode_bmn|regex:/^[A-Za-z0-9\-_]+$/',
            'nama_barang' => 'required|string|max:255',
            'kategori' => 'required|in:Elektronik,ATK,Kendaraan,Mebel,Arsip',
            'lokasi_simpan' => 'required|string|max:255',
            'status' => 'nullable|in:tersedia,terpakai,servis,rusak',
        ];
    }

    /**
     * Custom validation messages in Indonesian.
     */
    public function messages(): array
    {
        return [
            'kode_bmn.required' => 'Kode BMN wajib diisi.',
            'kode_bmn.unique' => 'Kode BMN ini sudah terdaftar dalam sistem.',
            'kode_bmn.regex' => 'Format kode BMN hanya boleh berupa huruf, angka, tanda hubung (-), dan garis bawah (_).',
            'nama_barang.required' => 'Nama barang wajib diisi.',
            'kategori.required' => 'Kategori aset wajib dipilih.',
            'kategori.in' => 'Kategori harus salah satu dari: Elektronik, ATK, Kendaraan, Mebel, atau Arsip.',
            'lokasi_simpan.required' => 'Lokasi penyimpanan barang wajib diisi.',
        ];
    }
}
