<?php

namespace App\Http\Controllers;

use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PhotoAlbumController extends Controller
{
    public function index(Request $request)
    {
        $query = Photo::query();

        // 1. Filter Pencarian berdasarkan Judul
        if ($request->filled('search')) {
            $query->where('title', 'like', '%' . $request->search . '%');
        }

        // 2. Filter Tanggal Upload
        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->date_from);
        }
        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->date_to);
        }

        // 3. Filter Ukuran File (Preset)
        if ($request->filled('size')) {
            switch ($request->size) {
                case 'small': // < 500 KB (512,000 Byte)
                    $query->where('file_size', '<', 512000);
                    break;
                case 'medium': // 500 KB - 2 MB
                    $query->whereBetween('file_size', [512000, 2097152]);
                    break;
                case 'large': // > 2 MB
                    $query->where('file_size', '>', 2097152);
                    break;
            }
        }

        // Fetch Data dengan urutan terbaru
        $photos = $query->latest()->get(['id', 'title', 'path', 'file_size', 'created_at']);

        // Format data URL, ukuran terformat, dan tanggal
        $photos->transform(function ($photo) {
            $photo->url = Storage::url($photo->path);
            $photo->formatted_size = $this->formatBytes($photo->file_size ?? 0);
            $photo->formatted_date = $photo->created_at ? $photo->created_at->format('d M Y H:i') : '-';
            return $photo;
        });

        if ($request->wantsJson()) {
            return response()->json($photos);
        }

        return view('compact.album.create', compact('photos'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'images'   => 'required|array',
            'images.*' => 'image|mimes:jpeg,png,jpg,webp',
        ]);

        if ($request->hasFile('images')) {
            foreach ($request->file('images') as $file) {
                $path = $file->store('photos', 'public');
                $fileSize = $file->getSize(); // Ambil ukuran file dalam byte
                $originalTitle = pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME);

                Photo::create([
                    'title'     => $originalTitle,
                    'path'      => $path,
                    'file_size' => $fileSize,
                ]);
            }
        }

        return redirect()->back()->with('success', 'Foto berhasil diunggah!');
    }

    public function update(Request $request, $id)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'image' => 'nullable|image|mimes:jpeg,png,jpg,webp|max:2048',
        ]);

        $photo = Photo::findOrFail($id);

        if ($request->hasFile('image')) {
            if (Storage::disk('public')->exists($photo->path)) {
                Storage::disk('public')->delete($photo->path);
            }
            $file = $request->file('image');
            $photo->path = $file->store('photos', 'public');
            $photo->file_size = $file->getSize();
        }

        $photo->title = $request->title;
        $photo->save();

        return redirect()->route('album.index')->with('success', 'Foto berhasil diperbarui!');
    }

    public function destroyBatch(Request $request)
    {
        $request->validate([
            'ids'   => 'required|array',
            'ids.*' => 'exists:photos,id',
        ]);

        $photos = Photo::whereIn('id', $request->ids)->get();

        foreach ($photos as $photo) {
            if (Storage::disk('public')->exists($photo->path)) {
                Storage::disk('public')->delete($photo->path);
            }
            $photo->delete();
        }

        return response()->json([
            'message' => count($photos) . ' foto berhasil dihapus.'
        ]);
    }

    // Helper untuk mengubah byte ke format B, KB, MB
    private function formatBytes($bytes, $precision = 2)
    {
        if ($bytes <= 0) return '0 B';
        $units = ['B', 'KB', 'MB', 'GB'];
        $i = floor(log($bytes, 1024));
        return round($bytes / pow(1024, $i), $precision) . ' ' . $units[$i];
    }
}