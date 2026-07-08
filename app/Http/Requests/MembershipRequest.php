<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class MembershipRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $isUpdate = $this->isMethod('PUT') || $this->isMethod('PATCH');

        return [
            'nama'           => 'required|string|max:255',
            'harga'          => 'required|numeric|min:0',
            'diskon'         => 'required|numeric|min:0|max:100', // Asumsi diskon berbasis persentase (0-100)
            'limit_siswa'    => 'required|integer|min:0',
            'limit_beasiswa' => 'required|integer|min:0',
            'masa_hingga'    => 'required|date',
            'limit_video'=> 'required|integer',
            'saldo_siswa'=> 'required|numeric',
            'gambar'         => $isUpdate ? 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048' : 'required|image|mimes:jpeg,png,jpg,webp|max:2048',
        ];
    }
}