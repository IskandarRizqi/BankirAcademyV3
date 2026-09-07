<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Article; // Sesuaikan namespace Article Anda
use Illuminate\Http\JsonResponse;

class ArticleController extends Controller
{
    /**
     * Get published articles (status = 1)
     */
    public function index(): JsonResponse
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
}
