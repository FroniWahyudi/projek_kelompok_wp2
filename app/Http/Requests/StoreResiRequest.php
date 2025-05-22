<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreResiRequest extends FormRequest
{
    public function authorize()
    {
        return true; // Ubah ke true agar request ini bisa digunakan
    }

    public function rules()
    {
        return [
            'kode' => 'required|string|max:20|unique:resi,kode',
            'tujuan' => 'required|string|max:100',
            'tanggal' => 'required|date',
            'status' => 'required|in:Pending,Selesai',
            'items' => 'required|array',
            'items.*.nama_item' => 'required|string',
            'items.*.qty' => 'required|integer|min:1',
        ];
    }
}
