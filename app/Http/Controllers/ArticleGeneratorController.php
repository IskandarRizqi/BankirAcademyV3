<?php

namespace App\Http\Controllers;

use App\Models\Article;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Stevebauman\Purify\Facades\Purify;
use Barryvdh\DomPDF\Facade\Pdf;

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

    public function publicIndex()
    {
        $articles = Article::where('status', 1)
            ->latest()
            ->paginate(9);

        return view('frontend.pages.article.index', compact('articles'));
    }

    public function publicShow($slug)
    {
        $article = Article::where('status', 1)
            ->where('slug', $slug)
            ->firstOrFail();

        return response($article->content)
            ->header('Content-Type', 'text/html; charset=UTF-8');
    }

    public function show($slug)
    {
        $article = Article::where('slug', $slug)->first();
        if (!$article->status) {
            abort(404);
        }


        return view('articles.show', compact('article'));
    }

    public function storeFromN8n(Request $request)
    {
        $validated = $request->validate([
            'keyword' => 'required|string',
            'title'   => 'required|string',
            'content' => 'required',
            'slug' => 'required'
        ]);
        // $cleanContent = Purify::clean($request->input('content'));

        $article = Article::create([
            'keyword' => $validated['keyword'],
            'title'   => $validated['title'],
            'content' => $validated['content'],
            'slug' => $validated['slug']
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

    public function update(Request $request, Article $article)
    {
        $validated = $request->validate([
            'keyword' => 'required|string|max:255',
            'title'   => 'required|string|max:255',
            'content' => 'required',
        ]);

        $article->update($validated);

        return redirect()->route('articles.index')->with('success', 'Artikel berhasil diperbarui!');
    }

    public function destroy(Article $article)
    {
        $article->delete();

        return back()->with('success', 'Artikel berhasil dihapus!');
    }
    public function publish(Article $article)
    {
        $article->update(['status' => 1]);
        return back()->with('success', 'Artikel berhasil di-publish!');
    }
    public function exportHtml(Article $article)
    {
        $fileName = $article->slug . '.html';

        // Buat struktur HTML lengkap dengan gaya tampilan yang rapi
        $htmlContent = "<!DOCTYPE html>
<html lang=\"id\">
<head>
    <meta charset=\"UTF-8\">
    <meta name=\"viewport\" content=\"width=device-width, initial-scale=1.0\">
    <title>" . htmlspecialchars($article->title) . "</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; max-width: 800px; margin: 0 auto; padding: 20px; }
        h1 { color: #1e293b; border-bottom: 2px solid #e2e8f0; padding-bottom: 10px; }
        .meta { font-size: 0.9em; color: #64748b; margin-bottom: 20px; }
        .keyword { background: #e0f2fe; color: #0369a1; padding: 3px 8px; border-radius: 4px; font-weight: bold; }
        .content { margin-top: 20px; }
    </style>
</head>
<body>
    <h1>" . htmlspecialchars($article->title) . "</h1>
    <div class=\"meta\">
        <span>Keyword: <span class=\"keyword\">" . htmlspecialchars($article->keyword) . "</span></span> | 
        <span>Dibuat: " . ($article->created_at ? $article->created_at->format('d M Y H:i') : '-') . "</span>
    </div>
    <hr>
    <div class=\"content\">
        " . $article->content . "
    </div>
</body>
</html>";

        return response($htmlContent)
            ->header('Content-Type', 'text/html')
            ->header('Content-Disposition', 'attachment; filename="' . $fileName . '"');
    }

    /**
     * Export semua artikel ke file CSV (dapat dibuka di Excel/Spreadsheet)
     * Kolom 'content' memuat seluruh string HTML artikel.
     */
    public function exportCsv()
    {
        $fileName = 'daftar_artikel_' . date('Y-m-d_H-i-s') . '.csv';
        $articles = Article::all();

        $headers = array(
            "Content-type"        => "text/csv; charset=UTF-8",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma"              => "no-cache",
            "Cache-Control"       => "must-revalidate, post-check=0, pre-check=0",
            "Expires"             => "0"
        );

        $columns = array('ID', 'Keyword Utama', 'Judul Artikel', 'Slug', 'Status Publish', 'Isi HTML Artikel (Content)', 'Tanggal Dibuat');

        $callback = function () use ($articles, $columns) {
            $file = fopen('php://output', 'w');
            // Tambahkan UTF-8 BOM agar aksen dan HTML karakter dibaca benar oleh Excel
            fprintf($file, chr(0xEF) . chr(0xBB) . chr(0xBF));

            fputcsv($file, $columns);

            foreach ($articles as $article) {
                $row['ID']             = $article->id;
                $row['Keyword Utama']  = $article->keyword;
                $row['Judul Artikel']  = $article->title;
                $row['Slug']           = $article->slug;
                $row['Status Publish'] = $article->status ? 'Published' : 'Draft';
                $row['Content']        = $article->content; // Mengandung HTML lengkap
                $row['Tanggal Dibuat'] = $article->created_at ? $article->created_at->format('Y-m-d H:i:s') : '';

                fputcsv($file, array(
                    $row['ID'],
                    $row['Keyword Utama'],
                    $row['Judul Artikel'],
                    $row['Slug'],
                    $row['Status Publish'],
                    $row['Content'],
                    $row['Tanggal Dibuat']
                ));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
    public function exportPdf(Article $article)
    {
        // Menyusun HTML utuh agar styling CSS internal terbaca rapi oleh DomPDF
        $htmlContent = "
        <!DOCTYPE html>
        <html>
        <head>
            <meta charset='utf-8'>
            <title>" . htmlspecialchars($article->title) . "</title>
            <style>
                body { font-family: sans-serif; font-size: 12pt; line-height: 1.6; color: #333; }
                h1 { font-size: 18pt; color: #1e293b; border-bottom: 2px solid #cbd5e1; padding-bottom: 8px; margin-bottom: 10px; }
                .meta { font-size: 9pt; color: #64748b; margin-bottom: 20px; }
                .badge { background: #e0f2fe; color: #0369a1; padding: 3px 6px; border-radius: 4px; font-weight: bold; }
                .content { margin-top: 20px; }
                img { max-width: 100%; height: auto; }
            </style>
        </head>
        <body>
            <h1>" . htmlspecialchars($article->title) . "</h1>
            <div class='meta'>
                <strong>Keyword:</strong> <span class='badge'>" . htmlspecialchars($article->keyword) . "</span> | 
                <strong>Tanggal:</strong> " . ($article->created_at ? $article->created_at->format('d M Y H:i') : '-') . "
            </div>
            <div class='content'>
                " . $article->content . "
            </div>
        </body>
        </html>";

        // Generate PDF dari string HTML
        $pdf = Pdf::loadHTML($htmlContent);

        // Download file PDF
        return $pdf->download($article->slug . '.pdf');
    }
}
