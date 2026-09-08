<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use Stevebauman\Purify\Facades\Purify;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\Storage;

class ArticleGeneratorController extends Controller
{
    public function index()
    {
        // Ambil data statistik dan daftar artikel
        $stats = [
            'total_artikel' => Article::count(),
            'total_keyword' => Article::distinct('keyword')->count(),
            'artikel_terbaru' => Article::latest()->first()?->created_at?->diffForHumans() ?? '-'
        ];

        $articles = Article::latest()->get();

        return view('articles.create', compact('articles', 'stats'));
    }
    public function apiIndex(): JsonResponse
    {
        // Mengambil artikel dengan status 1 dan mengurutkannya dari yang terbaru
        $articles = Article::where('status', 1)
            ->latest()
            ->paginate(10); // Bisa diganti ->get() jika tidak ingin memakai pagination

        return response()->json([
            'success' => true,
            'message' => 'Data artikel berhasil diambil',
            'data'    => $articles
        ], 200);
    }

    public function generate(Request $request)
    {
        $validated = $request->validate([
            'keyword' => 'required|string|max:255',
        ]);

        try {
            $response = Http::timeout(90)->post(config('services.n8n.webhook_url'), [
                'keyword' => $validated['keyword'],
            ]);

            if ($response->successful()) {
                return back()->with('success', 'Permintaan generate artikel berhasil dikirim ke n8n!');
            }

            return back()->with('error', 'Gagal memproses artikel dari n8n.');
        } catch (\Exception $e) {
            return back()->with('error', 'Koneksi ke n8n error/timeout: ' . $e->getMessage());
        }
    }

    public function publicIndex(Request $request)
    {
        // Menangkap input pencarian
        $search = $request->input('search');

        $articles = Article::where('status', 1)
            ->when($search, function ($query, $search) {
                // Gunakan closure agar orWhere tidak merusak kondisi status = 1
                return $query->where(function ($q) use ($search) {
                    $q->where('title', 'like', "%{$search}%")
                        ->orWhere('content', 'like', "%{$search}%")
                        ->orWhere('keyword', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(5)
            ->withQueryString(); // Mempertahankan parameter URL (search) pada link pagination

        return view('frontend.pages.article.index', compact('articles'));
    }

    public function publicShow($slug)
    {
        // 1. Ambil artikel utama yang sedang dibuka
        $article = Article::where('status', 1)
            ->where('slug', $slug)
            ->firstOrFail();

        // 2. Ambil artikel terkait (misal: 4 artikel acak/terbaru, selain artikel yang sedang dibuka)
        $relatedArticles = Article::where('status', 1)
            ->where('id', '!=', $article->id) // Hindari artikel yang sedang dibaca muncul di sidebar
            ->latest()                        // Atau gunakan ->inRandomOrder() jika ingin acak
            ->take(4)                         // Ambil 4 artikel saja
            ->get();

        // 3. Kirim variabel $article dan $relatedArticles ke view
        return view('articles.show', compact('article', 'relatedArticles'));
    }

    public function show($slug)
    {
        $article = Article::where('slug', $slug)->firstOrFail();
        $relatedArticles = Article::where('status', 1)
            ->where('id', '!=', $article->id) // Hindari artikel yang sedang dibaca muncul di sidebar
            ->latest()                        // Atau gunakan ->inRandomOrder() jika ingin acak
            ->take(4)                         // Ambil 4 artikel saja
            ->get();
        $user = auth()->user();
        if (!$article->status) {
            $isAuthorized = $user && ($user->role == 0 || $user->email === 'cb@bankir.academy');

            if (!$isAuthorized) {
                return back();
            }
        }

        return view('articles.show', compact('article', 'relatedArticles'));
    }
    public function storeFromN8n(Request $request)
    {
        $validated = $request->validate([
            'keyword' => 'required|string',
            'title'   => 'required|string',
            'content' => 'required',
            'meta_description' => 'required',
            'meta_keywords' => 'required',
            'slug' => 'required',
            'image_url' => 'required'
        ]);
        // $cleanContent = Purify::clean($request->input('content'));

        $article = Article::create([
            'keyword' => $validated['keyword'],
            'title'   => $validated['title'],
            'content' => $validated['content'],
            'meta_description' => $validated['meta_description'],
            'meta_keywords' => $validated['meta_keywords'],
            'slug' => $validated['slug'],
            'image_url' => $validated['image_url']
        ]);

        return response()->json([
            'status'  => 'success',
            'message' => 'Artikel berhasil disimpan ke Database Laravel',
            'data'    => $article
        ], 201);
    }
    public function edit(Article $article)
    {
        return view('articles.edit', compact('article'));
    }

    public function publish(Article $article)
    {
        $article->update(['status' => 1]);

        return back()->with('success', 'Artikel berhasil dipublikasikan!');
    }
    public function unpublish(Article $article)
    {
        $article->update(['status' => 0]);

        return back()->with('success', 'Artikel berhasil di-unpublish!');
    }
    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'keyword'          => 'required|string|max:255',
            'title'            => 'required|string|max:255',
            'slug'             => 'required|string|max:255|unique:articles,slug,' . $article->id,
            'meta_description' => 'nullable|string',
            'meta_keywords'    => 'nullable|string',
            'content'          => 'required|string',
            'image'            => 'nullable|image|mimes:jpeg,png,jpg,webp', // Validasi file upload
        ]);

        // Opsi handling gambar
        if ($request->hasFile('image')) {
            // Hapus gambar lama di storage lokal jika sebelumnya tersimpan secara lokal
            if ($article->image_url && !filter_var($article->image_url, FILTER_VALIDATE_URL)) {
                $oldPath = str_replace('/storage/', '', $article->image_url);
                Storage::disk('public')->delete($oldPath);
            }

            // Simpan gambar baru ke storage/app/public/articles
            $path = $request->file('image')->store('articles', 'public');
            $validated['image_url'] = Storage::url($path); // Output: /storage/articles/filename.jpg
        }

        $article->update($validated);

        return redirect()->route('articles.index')->with('success', 'Artikel berhasil diperbarui!');
    }
    public function upload(Request $request)
    {
        // 1. Validasi request
        $request->validate([
            'image' => 'required|image|mimes:jpeg,png,jpg,webp', // maks 5MB
        ]);

        if ($request->hasFile('image')) {
            $file = $request->file('image');

            // 2. Buat nama file acak sepanjang 40 karakter (contoh: fLxLfGU12qjjntZSfsONadLzN4KBBzsurYPGBDdU.jpg)
            $extension = $file->getClientOriginalExtension();
            $filename = Str::random(40) . '.' . $extension;

            // 3. Simpan file ke storage/app/public/articles/
            $file->storeAs('public/articles', $filename);

            // 4. Return path relatif sesuai format yang Anda minta
            $imageUrl = '/storage/articles/' . $filename;

            return response()->json([
                'success'   => true,
                'message'   => 'Image uploaded successfully',
                'image_url' => $imageUrl,
            ], 200);
        }

        return response()->json([
            'success' => false,
            'message' => 'No image provided',
        ], 400);
    }
    public function exportPdf(Article $article)
    {
        $pdf = Pdf::loadView('articles.pdf_single', compact('article'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('Artikel-' . $article->slug . '.pdf');
    }
    public function exportAllPdf()
    {
        $articles = Article::latest()->get();

        $pdf = Pdf::loadView('articles.pdf_all', compact('articles'))
            ->setPaper('a4', 'portrait');

        return $pdf->download('Daftar-Semua-Artikel-' . date('Y-m-d') . '.pdf');
    }

    public function destroy(Article $article)
    {
        $article->delete();

        return back()->with('success', 'Artikel berhasil dihapus!');
    }
}
