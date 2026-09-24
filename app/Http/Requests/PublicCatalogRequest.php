<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class PublicCatalogRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'q' => ['nullable', 'string', 'max:100'],
            'per_page' => ['nullable', 'integer', 'min:1', 'max:50'],
            'sort' => ['nullable', 'in:date,newest,order,name'],
            'direction' => ['nullable', 'in:asc,desc'],
            'category' => ['nullable', 'string', 'max:100'],
            'upcoming' => ['nullable', 'boolean'],
            'tipe_harga' => ['nullable', 'in:gratis,berbayar'],
        ];
    }
}
