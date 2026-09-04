<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\DokumenFileSopModel;
use App\Models\SopModel;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;
use Illuminate\Validation\ValidationException;
use Throwable;

class SopController extends Controller
{
    private const MAX_FILE_SIZE_KB = 102400;

    private const ALLOWED_EXTENSIONS = 'pdf,doc,docx,xls,xlsx,ppt,pptx';

    private const GOOGLE_DRIVE_HOSTS = [
        'drive.google.com',
        'docs.google.com',
        'drive.usercontent.google.com',
    ];

    public function index()
    {
        return view('backend.sop.index', $this->viewData());
    }

    public function create()
    {
        return view('backend.sop.index', $this->viewData());
    }

    public function store(Request $request)
    {
        $validated = $request->validate($this->validationRules());
        $this->validateDocumentRows($request);
        $directory = $this->sopDirectory($validated['judul']);

        if (File::isDirectory(public_path($directory))) {
            return back()
                ->withInput()
                ->withErrors(['judul' => 'Folder SOP dengan judul tersebut sudah digunakan.']);
        }

        $storedPaths = [];

        try {
            DB::transaction(function () use ($validated, $request, &$storedPaths) {
                $sop = SopModel::create([
                    'judul' => $validated['judul'],
                    'deskripsi' => $validated['deskripsi'] ?? null,
                    'status' => $validated['status'],
                ]);

                $this->storeDocuments($sop, $request, $storedPaths);
            });
        } catch (Throwable $exception) {
            $this->removeFiles($storedPaths);
            Log::error('Gagal menyimpan SOP.', ['exception' => $exception]);

            return back()->withInput()->with('error', 'Data SOP gagal disimpan.');
        }

        return redirect()->route('admin.sop.index')->with('success', 'Data SOP berhasil disimpan.');
    }

    public function edit(int $id)
    {
        return view('backend.sop.index', $this->viewData(SopModel::with('dokumenFiles')->findOrFail($id)));
    }

    public function update(Request $request, int $id)
    {
        $sop = SopModel::with('dokumenFiles')->findOrFail($id);
        $validated = $request->validate($this->validationRules($sop));
        $this->validateDocumentRows($request);
        $oldDirectory = $this->sopDirectory($sop->judul);
        $newDirectory = $this->sopDirectory($validated['judul']);
        $directoryMoved = false;
        $storedPaths = [];

        try {
            if ($oldDirectory !== $newDirectory && File::isDirectory(public_path($oldDirectory))) {
                if (File::isDirectory(public_path($newDirectory))) {
                    return back()->withInput()->with('error', 'Folder SOP dengan judul tersebut sudah digunakan.');
                }

                File::moveDirectory(public_path($oldDirectory), public_path($newDirectory));
                $directoryMoved = true;
            }

            DB::transaction(function () use ($sop, $validated, $request, $oldDirectory, $newDirectory, &$storedPaths) {
                $sop->update([
                    'judul' => $validated['judul'],
                    'deskripsi' => $validated['deskripsi'] ?? null,
                    'status' => $validated['status'],
                ]);

                if ($oldDirectory !== $newDirectory) {
                    $sop->dokumenFiles()->whereNotNull('path')->each(function (DokumenFileSopModel $document) use ($oldDirectory, $newDirectory) {
                        $document->update([
                            'path' => Str::replaceFirst($oldDirectory . '/', $newDirectory . '/', $document->path),
                        ]);
                    });
                }

                $this->storeDocuments($sop, $request, $storedPaths);
            });
        } catch (Throwable $exception) {
            $this->removeFiles($storedPaths);

            if ($directoryMoved && File::isDirectory(public_path($newDirectory))) {
                File::moveDirectory(public_path($newDirectory), public_path($oldDirectory));
            }

            Log::error('Gagal memperbarui SOP.', ['sop_id' => $sop->id, 'exception' => $exception]);

            return back()->withInput()->with('error', 'Data SOP gagal diperbarui.');
        }

        return redirect()->route('admin.sop.index')->with('success', 'Data SOP berhasil diperbarui.');
    }

    public function destroy(int $id)
    {
        $sop = SopModel::with('dokumenFiles')->findOrFail($id);
        $directory = $this->sopDirectory($sop->judul);

        DB::transaction(function () use ($sop) {
            $sop->delete();
        });

        if (File::isDirectory(public_path($directory))) {
            File::deleteDirectory(public_path($directory));
        }

        return redirect()->route('admin.sop.index')->with('success', 'Data SOP berhasil dihapus.');
    }

    public function destroyDocument(int $id)
    {
        $document = DokumenFileSopModel::with('sop')->findOrFail($id);
        $path = $document->path ? public_path($document->path) : null;
        $directory = $path ? dirname($path) : null;

        $document->delete();

        if ($path && File::exists($path)) {
            File::delete($path);
        }

        if ($directory) {
            $this->removeEmptyDirectory($directory);
        }

        return back()->with('success', 'Dokumen SOP berhasil dihapus.');
    }

    public function downloadDocument(int $id)
    {
        $document = DokumenFileSopModel::findOrFail($id);

        // 1. Redirect jika berupa link Google Drive
        if ($document->link_google_drive) {
            return redirect()->away($document->link_google_drive);
        }

        // 2. Normalisasi path file lokal
        $relativePath = ltrim($document->path, '/');
        $fullPath = public_path($relativePath);

        // 3. Cek keberadaan file di folder public/
        if (! File::exists($fullPath)) {
            abort(404, "File tidak ditemukan di path: " . $fullPath);
        }

        // 4. Ambil ekstensi asli dari path (misal: pdf, docx, xlsx)
        $extension = File::extension($fullPath);

        // 5. Pastikan nama_file memiliki ekstensi
        $downloadName = $document->nama_file;
        if (! Str::endsWith(strtolower($downloadName), '.' . strtolower($extension))) {
            $downloadName .= '.' . $extension;
        }

        // 6. Return response download
        return response()->download($fullPath, $downloadName);
    }

    private function viewData(?SopModel $sop = null): array
    {
        return [
            'sops' => SopModel::with('dokumenFiles')->latest('id')->get(),
            'sop' => $sop,
        ];
    }

    private function validationRules(?SopModel $sop = null): array
    {
        return [
            'judul' => [
                'required',
                'string',
                'max:255',
                Rule::unique('sop', 'judul')->ignore($sop?->id),
            ],
            'deskripsi' => ['nullable', 'string', 'max:1000'],
            'status' => ['required', Rule::in(SopModel::statuses())],
            'documents' => ['nullable', 'array'],
            'documents.*.type' => ['nullable', Rule::in(['file', 'link'])],
            'documents.*.nama_file' => ['nullable', 'string', 'max:255'],
            'documents.*.link_google_drive' => ['nullable', 'string', 'max:2048'],
            'documents.*.file' => [
                'nullable',
                'file',
                'max:' . self::MAX_FILE_SIZE_KB,
                'mimes:' . self::ALLOWED_EXTENSIONS,
            ],
        ];
    }

    private function storeDocuments(SopModel $sop, Request $request, array &$storedPaths): void
    {
        $documents = $request->input('documents', []);

        if ($documents === []) {
            return;
        }

        foreach ($documents as $index => $document) {
            $type = $document['type'] ?? 'link';

            if ($type === 'link') {
                $sop->dokumenFiles()->create([
                    'nama_file' => Str::limit($document['nama_file'] ?: 'Dokumen Google Drive', 255, ''),
                    'path' => '',
                    'ukuran' => 0,
                    'mime_type' => 'text/uri-list',
                    'link_google_drive' => $document['link_google_drive'],
                ]);

                continue;
            }

            $file = $request->file("documents.{$index}.file");
            if (! $file) {
                continue;
            }

            $directory = $this->sopDirectory($sop->judul);
            $absoluteDirectory = public_path($directory);

            if (! File::isDirectory($absoluteDirectory)) {
                File::makeDirectory($absoluteDirectory, 0755, true);
            }

            $filename = Str::uuid() . '.' . strtolower($file->extension());
            $originalName = Str::limit($file->getClientOriginalName(), 255, '');
            $fileSize = $file->getSize();
            $mimeType = $file->getMimeType();
            $file->move($absoluteDirectory, $filename);
            $relativePath = $directory . '/' . $filename;
            $storedPaths[] = $relativePath;

            $sop->dokumenFiles()->create([
                'nama_file' => Str::limit($document['nama_file'] ?: $originalName, 255, ''),
                'path' => $relativePath,
                'ukuran' => $fileSize,
                'mime_type' => $mimeType,
                'link_google_drive' => null,
            ]);
        }
    }

    private function validateDocumentRows(Request $request): void
    {
        $errors = [];

        foreach ((array) $request->input('documents', []) as $index => $document) {
            $type = $document['type'] ?? 'link';
            $link = trim((string) ($document['link_google_drive'] ?? ''));
            $file = $request->file("documents.{$index}.file");
            $name = trim((string) ($document['nama_file'] ?? ''));

            if ($name === '' && $link === '' && ! $file) {
                continue;
            }

            if ($type === 'link') {
                if ($link === '') {
                    $errors["documents.{$index}.link_google_drive"] = 'Link Google Drive wajib diisi.';
                } elseif (! $this->isGoogleDriveLink($link)) {
                    $errors["documents.{$index}.link_google_drive"] = 'Link harus berasal dari Google Drive.';
                }
            }

            if ($type === 'file' && ! $file) {
                $errors["documents.{$index}.file"] = 'File dokumen wajib dipilih.';
            }
        }

        if ($errors !== []) {
            throw ValidationException::withMessages($errors);
        }
    }

    private function isGoogleDriveLink(string $link): bool
    {
        $parsedUrl = parse_url($link);

        return ($parsedUrl['scheme'] ?? null) === 'https'
            && in_array(strtolower($parsedUrl['host'] ?? ''), self::GOOGLE_DRIVE_HOSTS, true);
    }

    private function sopDirectory(string $judul): string
    {
        $slug = Str::slug($judul);

        return 'image/sop/' . ($slug !== '' ? $slug : 'sop');
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

    private function removeEmptyDirectory(string $directory): void
    {
        if (! File::isDirectory($directory)) {
            return;
        }

        $entries = File::allFiles($directory);
        if ($entries === []) {
            File::deleteDirectory($directory);
        }
    }
}
