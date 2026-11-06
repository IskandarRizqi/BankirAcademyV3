<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\News;
use App\Models\NewsImage;
use App\Services\SitemapService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Stevebauman\Purify\Facades\Purify;

class NewsController extends Controller
{
    public function __construct(private SitemapService $sitemap) {}

    public function index(Request $request)
    {
        $news = News::with('bannerImages')
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->string('search')->toString();
                $query->where(function ($query) use ($search) {
                    $query->where('title', 'like', "%{$search}%")
                        ->orWhere('slug', 'like', "%{$search}%");
                });
            })
            ->when($request->filled('status'), fn ($query) => $query->where('status', (int) $request->status))
            ->latest()
            ->paginate(15)
            ->withQueryString();

        $stats = [
            'total' => News::count(),
            'published' => News::where('status', true)->count(),
            'views' => News::sum('views'),
        ];

        return view('news.admin.index', compact('news', 'stats'));
    }

    public function create()
    {
        return view('news.admin.create');
    }

    public function store(Request $request)
    {
        $validated = $this->validateNews($request, true);
        $news = null;

        DB::transaction(function () use ($request, $validated, &$news) {
            $news = News::create($this->newsAttributes($validated));
            $this->storeImages($request, $news);
        });

        if ($news->status) {
            $this->regenerateSitemap();
        }

        return redirect()->route('admin.news.index')->with('success', 'Berita berhasil dibuat.');
    }

    public function edit(News $news)
    {
        $news->load('bannerImages');

        return view('news.admin.edit', compact('news'));
    }

    public function update(Request $request, News $news)
    {
        $wasPublished = $news->status;
        $validated = $this->validateNews($request);

        DB::transaction(function () use ($request, $validated, $news) {
            $news->update($this->newsAttributes($validated));

            $removeIds = collect($request->input('remove_images', []))->map(fn ($id) => (int) $id);
            $news->bannerImages()->whereIn('id', $removeIds)->get()->each(function (NewsImage $image) {
                $this->deleteImage($image);
            });

            $this->storeImages($request, $news);
        });

        if ($wasPublished || $news->status) {
            $this->regenerateSitemap();
        }

        return redirect()->route('admin.news.index')->with('success', 'Berita berhasil diperbarui.');
    }

    public function publish(News $news)
    {
        $news->update(['status' => true, 'published_at' => $news->published_at ?? now()]);
        $this->regenerateSitemap();

        return back()->with('success', 'Berita berhasil dipublikasikan.');
    }

    public function unpublish(News $news)
    {
        $news->update(['status' => false]);
        $this->regenerateSitemap();

        return back()->with('success', 'Berita dipindahkan ke draft.');
    }

    public function destroy(News $news)
    {
        $wasPublished = $news->status;
        $news->load('bannerImages');
        $news->bannerImages->each(fn (NewsImage $image) => $this->deleteImage($image));
        $news->delete();

        if ($wasPublished) {
            $this->regenerateSitemap();
        }

        return back()->with('success', 'Berita berhasil dihapus.');
    }

    private function validateNews(Request $request, bool $requireImage = false): array
    {
        $rules = [
            'title' => ['required', 'string', 'max:255'],
            'slug' => ['nullable', 'string', 'max:255', 'unique:news,slug,'.optional($request->route('news'))->id],
            'excerpt' => ['nullable', 'string', 'max:320'],
            'content' => ['required', 'string'],
            'meta_title' => ['nullable', 'string', 'max:70'],
            'meta_description' => ['nullable', 'string', 'max:160'],
            'meta_keywords' => ['nullable', 'string', 'max:255'],
            'status' => ['required', 'boolean'],
            'banner_images' => [$requireImage ? 'required' : 'nullable', 'array', 'max:10'],
            'banner_images.*' => ['image', 'mimes:jpg,jpeg,png,webp', 'max:5120'],
            'remove_images' => ['nullable', 'array'],
            'remove_images.*' => ['integer'],
        ];

        return $request->validate($rules);
    }

    private function newsAttributes(array $validated): array
    {
        $slug = filled($validated['slug'] ?? null) ? Str::slug($validated['slug']) : Str::slug($validated['title']);
        $slug = $this->uniqueSlug($slug);
        $isPublished = (bool) $validated['status'];

        return [
            'title' => $validated['title'],
            'slug' => $slug,
            'excerpt' => $validated['excerpt'] ?? Str::limit(trim(strip_tags($validated['content'])), 240),
            'content' => Purify::clean($validated['content']),
            'meta_title' => $validated['meta_title'] ?? $validated['title'],
            'meta_description' => $validated['meta_description'] ?? Str::limit(trim(strip_tags($validated['content'])), 160),
            'meta_keywords' => $validated['meta_keywords'] ?? null,
            'status' => $isPublished,
            'published_at' => $isPublished ? ($this->currentPublishedAt() ?? now()) : null,
        ];
    }

    private function currentPublishedAt()
    {
        $news = request()->route('news');

        return $news instanceof News ? $news->published_at : null;
    }

    private function uniqueSlug(string $slug): string
    {
        $base = $slug ?: 'berita';
        $candidate = $base;
        $suffix = 2;
        $current = request()->route('news');

        while (News::where('slug', $candidate)
            ->when($current instanceof News, fn ($query) => $query->where('id', '!=', $current->id))
            ->exists()) {
            $candidate = $base.'-'.$suffix++;
        }

        return $candidate;
    }

    private function storeImages(Request $request, News $news): void
    {
        $nextOrder = (int) $news->bannerImages()->max('sort_order') + 1;

        foreach ($request->file('banner_images', []) as $index => $file) {
            $path = $file->store('news', 'public');
            $news->bannerImages()->create([
                'path' => $path,
                'sort_order' => $nextOrder + $index,
            ]);
        }
    }

    private function deleteImage(NewsImage $image): void
    {
        Storage::disk('public')->delete($image->path);
        $image->delete();
    }

    private function regenerateSitemap(): void
    {
        try {
            $this->sitemap->generate();
        } catch (\Throwable $exception) {
            Log::error('Gagal memperbarui sitemap berita.', ['exception' => $exception]);
        }
    }
}
