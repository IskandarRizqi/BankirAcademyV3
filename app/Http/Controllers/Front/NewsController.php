<?php

namespace App\Http\Controllers\Front;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\LokerModel;
use App\Models\News;
use Illuminate\Http\Request;

class NewsController extends Controller
{
    public function index(Request $request)
    {
        $news = News::published()
            ->with('bannerImages')
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->string('search')->toString();
                $query->where(function ($query) use ($search) {
                    $query->where('title', 'like', "%{$search}%")
                        ->orWhere('excerpt', 'like', "%{$search}%")
                        ->orWhere('content', 'like', "%{$search}%");
                });
            })
            ->latest('published_at')
            ->latest('id')
            ->paginate(9)
            ->withQueryString();

        return view('news.index', compact('news'));
    }

    public function show(string $slug)
    {
        $news = News::published()->with('bannerImages')->where('slug', $slug)->firstOrFail();
        News::whereKey($news->id)->increment('views');
        $news->refresh();
        $news->load('bannerImages');

        $relatedNews = News::published()
            ->with('bannerImages')
            ->where('id', '!=', $news->id)
            ->latest('published_at')
            ->take(3)
            ->get();
        $relatedArticles = Article::where('status', 1)->latest()->take(3)->get();
        $relatedJobs = LokerModel::where('status', 1)
            ->whereDate('tanggal_awal', '<=', now())
            ->whereDate('tanggal_akhir', '>=', now())
            ->latest()
            ->take(3)
            ->get();

        return view('news.show', compact('news', 'relatedNews', 'relatedArticles', 'relatedJobs'));
    }
}
