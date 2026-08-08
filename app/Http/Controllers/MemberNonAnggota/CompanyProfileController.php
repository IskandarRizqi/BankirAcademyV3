<?php

namespace App\Http\Controllers\MemberNonAnggota;

use App\Http\Controllers\Controller;
use App\Models\PerusahaanModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Throwable;

class CompanyProfileController extends Controller
{
    private const MAX_LOGO_SIZE_KB = 2048;

    public function edit(Request $request)
    {
        $company = $this->companyForUser($request);

        return view('membernonkeanggotaan.pages.loker.company-profile', [
            'company' => $company,
            'provinces' => DB::table('provinsi')->select(['id', 'name'])->orderBy('name')->get(),
            'selectedLocations' => $this->selectedLocations($request, $company),
        ]);
    }

    public function update(Request $request)
    {
        $company = $this->companyForUser($request);
        $payload = $request->all();
        $validator = Validator::make($payload, $this->rules($request, $company));

        if ($validator->fails()) {
            return back()
                ->withInput()
                ->withErrors($validator)
                ->with('error', 'Data perusahaan belum lengkap. Periksa kembali isian Anda.');
        }

        $validated = $validator->validated();
        $storedPath = null;
        $oldPath = $company ? $this->imagePath($company->image) : null;

        try {
            DB::transaction(function () use ($request, $validated, &$storedPath) {
                $attributes = [
                    'nama' => $validated['nama'],
                    'email' => $validated['email'],
                    'alamat' => $validated['alamat'],
                    'provinsi' => $validated['provinsi'],
                    'kabupaten' => $validated['kabupaten'],
                    'kecamatan' => $validated['kecamatan'],
                    'kelurahan' => $validated['kelurahan'],
                ];

                if ($request->hasFile('image')) {
                    $image = $request->file('image');
                    $imageSize = $image->getSize();
                    $storedPath = $this->storeLogo($image);
                    $attributes['image'] = json_encode([
                        'url' => basename($storedPath),
                        'size' => $imageSize,
                    ]);
                }

                PerusahaanModel::updateOrCreate(
                    ['user_id' => $request->user()->id],
                    $attributes
                );
            });
        } catch (Throwable $exception) {
            if ($storedPath) {
                $this->removeFile($storedPath);
            }

            report($exception);

            return back()
                ->withInput()
                ->with('error', 'Data perusahaan gagal disimpan.');
        }

        if ($oldPath && $storedPath && $oldPath !== $storedPath) {
            $this->removeFile($oldPath);
        }

        return redirect()
            ->route('membernonanggota.loker.manage.company.edit')
            ->with('success', 'Data perusahaan berhasil disimpan.');
    }

    private function companyForUser(Request $request): ?PerusahaanModel
    {
        return PerusahaanModel::where('user_id', $request->user()->id)->first();
    }

    private function rules(Request $request, ?PerusahaanModel $company): array
    {
        $provinceId = $request->input('provinsi');
        $cityId = $request->input('kabupaten');
        $districtId = $request->input('kecamatan');

        return [
            'nama' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'alamat' => ['required', 'string', 'max:2000'],
            'provinsi' => ['required', 'integer', Rule::exists('provinsi', 'id')],
            'kabupaten' => [
                'required',
                'integer',
                Rule::exists('kota', 'id')->where(fn ($query) => $query->where('provinsi_id', $provinceId)),
            ],
            'kecamatan' => [
                'required',
                'integer',
                Rule::exists('kecamatan', 'id')->where(fn ($query) => $query->where('kota_id', $cityId)),
            ],
            'kelurahan' => [
                'required',
                'integer',
                Rule::exists('kelurahan', 'id')->where(fn ($query) => $query->where('kecamatan_id', $districtId)),
            ],
            'image' => [
                $company && filled($company->image) ? 'nullable' : 'required',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:'.self::MAX_LOGO_SIZE_KB,
            ],
        ];
    }

    private function selectedLocations(Request $request, ?PerusahaanModel $company): array
    {
        $provinceId = $request->session()->getOldInput('provinsi', $company?->provinsi);
        $cityId = $request->session()->getOldInput('kabupaten', $company?->kabupaten);
        $districtId = $request->session()->getOldInput('kecamatan', $company?->kecamatan);

        if (! $provinceId) {
            return ['cities' => collect(), 'districts' => collect(), 'villages' => collect()];
        }

        return [
            'cities' => DB::table('kota')->where('provinsi_id', $provinceId)->orderBy('name')->get(),
            'districts' => $cityId
                ? DB::table('kecamatan')->where('kota_id', $cityId)->orderBy('name')->get()
                : collect(),
            'villages' => $districtId
                ? DB::table('kelurahan')->where('kecamatan_id', $districtId)->orderBy('name')->get()
                : collect(),
        ];
    }

    private function storeLogo($file): string
    {
        $directory = public_path('image/loker');
        File::ensureDirectoryExists($directory);
        $path = 'image/loker/company-'.Str::uuid().'.'.strtolower($file->extension());
        $file->move(public_path('image/loker'), basename($path));

        return $path;
    }

    private function imagePath(?string $image): ?string
    {
        $decoded = json_decode((string) $image, true);
        $filename = is_array($decoded) ? ($decoded['url'] ?? null) : null;

        return $filename ? 'image/loker/'.basename($filename) : null;
    }

    private function removeFile(string $relativePath): void
    {
        $path = public_path($relativePath);

        if (File::exists($path)) {
            File::delete($path);
        }
    }
}
