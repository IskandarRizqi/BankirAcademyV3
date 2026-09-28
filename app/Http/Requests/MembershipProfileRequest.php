<?php

namespace App\Http\Requests;

use App\Models\DataPayment;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class MembershipProfileRequest extends FormRequest
{
    public function authorize(): bool
    {
        return auth()->check();
    }

    public function rules(): array
    {
        return self::profileRules($this->all());
    }

    public static function profileRules(array $input): array
    {
        $provinceId = $input['provinsi_id'] ?? null;
        $cityId = $input['kota_id'] ?? null;
        $districtId = $input['kecamatan_id'] ?? null;

        return [
            'membership_tipe' => ['nullable', 'integer', Rule::in(DataPayment::MEMBERSHIP_TYPES)],
            'name' => ['required', 'string', 'max:255'],
            'phone' => [
                'required',
                'string',
                'regex:/^[0-9+() -]+$/',
                'max:30',
                function ($attribute, $value, $fail) {
                    $digits = preg_replace('/\D+/', '', (string) $value);

                    if (str_starts_with($digits, '62')) {
                        $digits = substr($digits, 2);
                    } elseif (str_starts_with($digits, '0')) {
                        $digits = substr($digits, 1);
                    }

                    if (strlen($digits) < 8) {
                        $fail('Nomor HP harus diisi lengkap setelah kode negara 62.');
                    }
                },
            ],
            'gender' => ['required', 'integer', Rule::in([0, 1])],
            'tanggal_lahir' => ['required', 'date', 'before_or_equal:today'],
            'alamat' => ['required', 'string', 'max:2000'],
            'provinsi_id' => ['required', 'integer', Rule::exists('provinsi', 'id')],
            'kota_id' => [
                'required',
                'integer',
                Rule::exists('kota', 'id')->where(fn ($query) => $query->where('provinsi_id', $provinceId)),
            ],
            'kecamatan_id' => [
                'required',
                'integer',
                Rule::exists('kecamatan', 'id')->where(fn ($query) => $query->where('kota_id', $cityId)),
            ],
            'kelurahan_id' => [
                'required',
                'integer',
                Rule::exists('kelurahan', 'id')->where(fn ($query) => $query->where('kecamatan_id', $districtId)),
            ],
        ];
    }
}
