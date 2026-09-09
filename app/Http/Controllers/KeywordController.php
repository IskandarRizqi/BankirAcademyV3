<?php

namespace App\Http\Controllers;

use App\Models\Keyword;
use Illuminate\Http\Request;

class KeywordController extends Controller
{
    public function index()
    {
        $keywords = Keyword::latest()->get();

        $stats = [
            'total_keyword' => Keyword::count(),
            'pending'       => Keyword::where('status', 'pending')->count(),
            'completed'     => Keyword::where('status', 'completed')->count(),
        ];

        return view('keywords.index', compact('keywords', 'stats'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'keyword' => 'required|string|max:255|unique:keywords,keyword',
        ], [
            'keyword.unique' => 'Keyword ini sudah ada di dalam antrean.',
        ]);

        Keyword::create([
            'keyword' => $validated['keyword'],
            'status'  => 'pending',
        ]);

        return back()->with('success', 'Keyword berhasil ditambahkan ke antrean!');
    }

    public function update(Request $request, Keyword $keyword)
    {
        $validated = $request->validate([
            'keyword' => 'required|string|max:255|unique:keywords,keyword,' . $keyword->id,
            'status'  => 'required|in:pending,processing,completed,failed',
        ]);

        $keyword->update($validated);

        return back()->with('success', 'Keyword berhasil diperbarui!');
    }

    public function destroy(Keyword $keyword)
    {
        $keyword->delete();

        return back()->with('success', 'Keyword berhasil dihapus!');
    }
}
