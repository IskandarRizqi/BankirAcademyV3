<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\BonusAplikasiModel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Throwable;

class BonusAplikasiController extends Controller
{
    private const MAX_ZIP_SIZE_KB = 102400;

    private const MAX_THUMBNAIL_SIZE_KB = 2048;

    public function index()
    {
        return view('backend.bonus-aplikasi.index', $this->viewData());
    }

    public function create()
    {
        return view('backend.bonus-aplikasi.index', $this->viewData());
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->validationRules());
        $this->validateSource($request);
        $storedPaths = [];

        try {
            DB::transaction(function () use ($validated, $request, &$storedPaths) {
                $bonus = BonusAplikasiModel::create([
                    'nama' => $validated['nama'],
                    'deskripsi' => $validated['deskripsi'] ?? null,
                    'status' => $validated['status'],
                    'tipe_sumber' => $validated['tipe_sumber'],
                ]);

                $this->storeAssets($bonus, $request, $storedPaths);
            });
        } catch (Throwable $exception) {
            $this->removeFiles($storedPaths);
            Log::error('Gagal menyimpan bonus aplikasi.', ['exception' => $exception]);

            return back()->withInput()->with('error', 'Bonus aplikasi gagal disimpan.');
        }

        return redirect()->route('admin.bonus_aplikasi.index')
            ->with('success', 'Bonus aplikasi berhasil disimpan.');
    }

    public function edit(int $id)
    {
        return view('backend.bonus-aplikasi.index', $this->viewData(BonusAplikasiModel::findOrFail($id)));
    }

    public function update(Request $request, int $id)
    {
        $bonus = BonusAplikasiModel::findOrFail($id);
        $validated = $request->validate($this->validationRules($bonus));
        $this->validateSource($request, $bonus);
        $storedPaths = [];
        $oldPaths = [];

        try {
            DB::transaction(function () use ($bonus, $validated, $request, &$storedPaths, &$oldPaths) {
                $bonus->update([
                    'nama' => $validated['nama'],
                    'deskripsi' => $validated['deskripsi'] ?? null,
                    'status' => $validated['status'],
                    'tipe_sumber' => $validated['tipe_sumber'],
                ]);

                if ($validated['tipe_sumber'] === BonusAplikasiModel::SOURCE_URL) {
                    if ($bonus->file_path) {
                        $oldPaths[] = $bonus->file_path;
                    }

                    $bonus->update([
                        'url' => $validated['url'],
                        'file_path' => null,
                        'file_name' => null,
                        'file_size' => null,
                        'mime_type' => null,
                    ]);
                } elseif ($request->hasFile('file')) {
                    if ($bonus->file_path) {
                        $oldPaths[] = $bonus->file_path;
                    }

                    $fileData = $this->storeFile($bonus, $request->file('file'), $storedPaths);
                    $bonus->update([
                        'url' => null,
                        ...$fileData,
                    ]);
                } else {
                    $bonus->update(['url' => null]);
                }

                if ($request->hasFile('thumbnail')) {
                    if ($bonus->thumbnail_path) {
                        $oldPaths[] = $bonus->thumbnail_path;
                    }

                    $thumbnailPath = $this->storeThumbnail($bonus, $request->file('thumbnail'), $storedPaths);
                    $bonus->update(['thumbnail_path' => $thumbnailPath]);
                }
            });
        } catch (Throwable $exception) {
            $this->removeFiles($storedPaths);
            Log::error('Gagal memperbarui bonus aplikasi.', [
                'bonus_aplikasi_id' => $bonus->id,
                'exception' => $exception,
            ]);

            return back()->withInput()->with('error', 'Bonus aplikasi gagal diperbarui.');
        }

        $this->removeFiles($oldPaths);

        return redirect()->route('admin.bonus_aplikasi.index')
            ->with('success', 'Bonus aplikasi berhasil diperbarui.');
    }

    public function destroy(int $id)
    {
        $bonus = BonusAplikasiModel::findOrFail($id);
        $directory = $this->bonusDirectory($bonus);

        DB::transaction(function () use ($bonus) {
            $bonus->delete();
        });

        if (File::isDirectory(public_path($directory))) {
            File::deleteDirectory(public_path($directory));
        }

        return redirect()->route('admin.bonus_aplikasi.index')
            ->with('success', 'Bonus aplikasi berhasil dihapus.');
    }

    public function download(int $id)
    {
        $bonus = BonusAplikasiModel::findOrFail($id);

        abort_unless($bonus->tipe_sumber === BonusAplikasiModel::SOURCE_FILE && $bonus->file_path, 404);

        $path = public_path($bonus->file_path);
        abort_unless(File::exists($path), 404);

        return response()->download($path, $bonus->file_name ?: basename($path));
    }

    private function viewData(?BonusAplikasiModel $bonus = null): array
    {
        return [
            'bonusAplikasi' => $bonus,
            'bonusAplikasiList' => BonusAplikasiModel::latest('id')->get(),
        ];
    }

    private function validationRules(?BonusAplikasiModel $bonus = null): array
    {
        return [
            'nama' => [
                'required',
                'string',
                'max:255',
                Rule::unique('bonus_aplikasi', 'nama')->ignore($bonus?->id),
            ],
            'deskripsi' => ['nullable', 'string', 'max:1000'],
            'status' => ['required', Rule::in(BonusAplikasiModel::statuses())],
            'tipe_sumber' => ['required', Rule::in(BonusAplikasiModel::sources())],
            'url' => ['nullable', 'string', 'max:2048'],
            'file' => ['nullable', 'file', 'mimes:zip', 'max:'.self::MAX_ZIP_SIZE_KB],
            'thumbnail' => [
                'nullable',
                'image',
                'mimes:jpg,jpeg,png,webp',
                'max:'.self::MAX_THUMBNAIL_SIZE_KB,
            ],
        ];
    }

    private function validateSource(Request $request, ?BonusAplikasiModel $bonus = null): void
    {
        $source = $request->input('tipe_sumber');
        $url = trim((string) $request->input('url'));
        $file = $request->file('file');

        if ($source === BonusAplikasiModel::SOURCE_URL) {
            if ($url === '' || ! filter_var($url, FILTER_VALIDATE_URL)) {
                throw ValidationException::withMessages([
                    'url' => 'URL bonus aplikasi wajib berupa URL yang valid.',
                ]);
            }

            $scheme = strtolower((string) parse_url($url, PHP_URL_SCHEME));
            if (! in_array($scheme, ['http', 'https'], true)) {
                throw ValidationException::withMessages([
                    'url' => 'URL bonus aplikasi harus menggunakan HTTP atau HTTPS.',
                ]);
            }

            return;
        }

        if (! $file && (! $bonus || ! $bonus->file_path)) {
            throw ValidationException::withMessages([
                'file' => 'File bonus aplikasi berformat ZIP wajib diunggah.',
            ]);
        }
    }

    private function storeAssets(BonusAplikasiModel $bonus, Request $request, array &$storedPaths): void
    {
        if ($request->input('tipe_sumber') === BonusAplikasiModel::SOURCE_URL) {
            $bonus->update([
                'url' => $request->input('url'),
                'file_path' => null,
                'file_name' => null,
                'file_size' => null,
                'mime_type' => null,
            ]);
        } else {
            $fileData = $this->storeFile($bonus, $request->file('file'), $storedPaths);
            $bonus->update([
                'url' => null,
                ...$fileData,
            ]);
        }

        if ($request->hasFile('thumbnail')) {
            $bonus->update([
                'thumbnail_path' => $this->storeThumbnail($bonus, $request->file('thumbnail'), $storedPaths),
            ]);
        }
    }

    private function storeFile(BonusAplikasiModel $bonus, $file, array &$storedPaths): array
    {
        $directory = $this->bonusDirectory($bonus);
        $absoluteDirectory = public_path($directory);
        $this->ensureDirectory($absoluteDirectory);

        $originalName = Str::limit($file->getClientOriginalName(), 255, '');
        $fileSize = $file->getSize();
        $mimeType = $file->getMimeType();
        $filename = Str::uuid().'.zip';

        $file->move($absoluteDirectory, $filename);
        $relativePath = $directory.'/'.$filename;
        $storedPaths[] = $relativePath;

        return [
            'file_path' => $relativePath,
            'file_name' => $originalName,
            'file_size' => $fileSize,
            'mime_type' => $mimeType,
        ];
    }

    private function storeThumbnail(BonusAplikasiModel $bonus, $file, array &$storedPaths): string
    {
        $directory = $this->bonusDirectory($bonus);
        $absoluteDirectory = public_path($directory);
        $this->ensureDirectory($absoluteDirectory);
        $filename = 'thumbnail-'.Str::uuid().'.'.strtolower($file->extension());

        $file->move($absoluteDirectory, $filename);
        $relativePath = $directory.'/'.$filename;
        $storedPaths[] = $relativePath;

        return $relativePath;
    }

    private function bonusDirectory(BonusAplikasiModel $bonus): string
    {
        return 'image/bonus-aplikasi/'.$bonus->id;
    }

    private function ensureDirectory(string $directory): void
    {
        if (! File::isDirectory($directory)) {
            File::makeDirectory($directory, 0755, true);
        }
    }

    private function removeFiles(array $relativePaths): void
    {
        foreach ($relativePaths as $relativePath) {
            $path = public_path($relativePath);

            if (File::exists($path)) {
                File::delete($path);
            }
        }
    }
}
