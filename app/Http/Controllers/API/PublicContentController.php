<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\LokerModel;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class PublicContentController extends Controller
{
    public function articles(Request $request): JsonResponse
    {
        $articles = Article::query()
            ->where('status', 1)
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->string('search')->toString();

                $query->where(function ($query) use ($search) {
                    $query->where('title', 'like', "%{$search}%")
                        ->orWhere('content', 'like', "%{$search}%")
                        ->orWhere('keyword', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(min($request->integer('per_page', 15), 50));

        return response()->json([
            'success' => true,
            'message' => 'Daftar artikel berhasil diambil.',
            'data' => $articles->getCollection()->map(fn (Article $article) => $this->articleData($article))->values(),
            'meta' => [
                'current_page' => $articles->currentPage(),
                'last_page' => $articles->lastPage(),
                'per_page' => $articles->perPage(),
                'total' => $articles->total(),
            ],
        ]);
    }

    public function article(string $slug): JsonResponse
    {
        $article = Article::query()
            ->where('status', 1)
            ->where('slug', $slug)
            ->first();

        if (! $article) {
            return response()->json([
                'success' => false,
                'message' => 'Artikel tidak ditemukan.',
            ], 404);
        }

        $related = Article::query()
            ->where('status', 1)
            ->where('id', '!=', $article->id)
            ->where('keyword', $article->keyword)
            ->latest()
            ->take(4)
            ->get();

        return response()->json([
            'success' => true,
            'message' => 'Artikel berhasil diambil.',
            'data' => array_merge($this->articleData($article, true), [
                'related_articles' => $related->map(fn (Article $item) => $this->articleData($item))->values(),
            ]),
        ]);
    }

    public function jobs(Request $request): JsonResponse
    {
        $jobs = LokerModel::query()
            ->where('status', 1)
            ->whereDate('tanggal_awal', '<=', today())
            ->whereDate('tanggal_akhir', '>=', today())
            ->when($request->filled('search'), function ($query) use ($request) {
                $search = $request->string('search')->toString();

                $query->where(function ($query) use ($search) {
                    $query->where('title', 'like', "%{$search}%")
                        ->orWhere('skill', 'like', "%{$search}%")
                        ->orWhere('type', 'like', "%{$search}%");
                });
            })
            ->latest()
            ->paginate(min($request->integer('per_page', 15), 50));

        return response()->json([
            'success' => true,
            'message' => 'Daftar lowongan kerja berhasil diambil.',
            'data' => $jobs->getCollection()->map(fn (LokerModel $job) => $this->jobData($job))->values(),
            'meta' => [
                'current_page' => $jobs->currentPage(),
                'last_page' => $jobs->lastPage(),
                'per_page' => $jobs->perPage(),
                'total' => $jobs->total(),
            ],
        ]);
    }

    public function job(int $id): JsonResponse
    {
        $job = LokerModel::query()
            ->where('status', 1)
            ->whereDate('tanggal_awal', '<=', today())
            ->whereDate('tanggal_akhir', '>=', today())
            ->find($id);

        if (! $job) {
            return response()->json([
                'success' => false,
                'message' => 'Lowongan kerja tidak ditemukan.',
            ], 404);
        }

        return response()->json([
            'success' => true,
            'message' => 'Lowongan kerja berhasil diambil.',
            'data' => $this->jobData($job, true),
        ]);
    }

    private function articleData(Article $article, bool $includeContent = false): array
    {
        $data = [
            'id' => $article->id,
            'slug' => $article->slug,
            'title' => $article->title,
            'keyword' => $article->keyword,
            'excerpt' => Str::limit(trim(strip_tags((string) $article->content)), 300),
            'image_url' => $this->assetUrl($article->image_url),
            'meta_description' => $article->meta_description,
            'created_at' => optional($article->created_at)->toISOString(),
            'updated_at' => optional($article->updated_at)->toISOString(),
        ];

        if ($includeContent) {
            $data['content'] = $article->content;
        }

        return $data;
    }

    private function jobData(LokerModel $job, bool $includeDescription = false): array
    {
        $company = $job->perusahaan;
        $data = [
            'id' => $job->id,
            'title' => $job->title,
            'type' => $job->type,
            'skill' => $job->skill,
            'salary_min' => $job->gaji_min,
            'salary_max' => $job->gaji_max,
            'image_url' => $this->assetUrl($job->image),
            'start_date' => $job->tanggal_awal,
            'end_date' => $job->tanggal_akhir,
            'location' => [
                'address' => $job->alamat,
                'province_id' => $job->provinsi,
                'city_id' => $job->kabupaten,
                'district_id' => $job->kecamatan,
                'village_id' => $job->kelurahan,
            ],
            'company' => $company ? [
                'id' => $company->id,
                'name' => $company->nama,
                'image_url' => $this->assetUrl($company->image),
            ] : null,
        ];

        if ($includeDescription) {
            $data['description'] = $job->deskripsi;
            $data['jobdesk'] = $job->jobdesk;
        }

        return $data;
    }

    private function assetUrl(?string $path): ?string
    {
        if (! $path) {
            return null;
        }

        return Str::startsWith($path, ['http://', 'https://', 'data:'])
            ? $path
            : asset(ltrim($path, '/'));
    }
}
