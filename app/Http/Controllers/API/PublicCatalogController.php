<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use App\Http\Requests\PublicCatalogRequest;
use App\Http\Resources\PublicClassResource;
use App\Http\Resources\PublicEbookResource;
use App\Http\Resources\PublicInteractiveVideoResource;
use App\Models\ClassesModel;
use App\Models\SubMateriModel;

class PublicCatalogController extends Controller
{
    public function classes(PublicCatalogRequest $request)
    {
        $filters = $request->validated();
        $direction = $filters['direction'] ?? 'asc';

        $query = ClassesModel::query()
            ->select([
                'id',
                'slug',
                'title',
                'category',
                'sub_category',
                'tags',
                'image',
                'image_mobile',
                'content',
                'date_start',
                'date_end',
                'class_date',
                'tipe',
                'level',
                'jenis',
                'kategori',
                'custom_jadwal',
                'iht',
                'status',
            ])
            ->with([
                'classEvents' => function ($query) {
                    $query->select([
                        'id',
                        'class_id',
                        'type',
                        'location',
                        'description',
                        'time_start',
                        'time_end',
                    ])->orderBy('time_start');
                },
                'pricingData',
            ])
            ->where('status', 1);

        if (! empty($filters['q'])) {
            $search = $filters['q'];
            $query->where(function ($query) use ($search) {
                $query->where('title', 'like', "%{$search}%")
                    ->orWhere('category', 'like', "%{$search}%")
                    ->orWhere('content', 'like', "%{$search}%");
            });
        }

        if (! empty($filters['category'])) {
            $query->where('category', $filters['category']);
        }

        if (array_key_exists('upcoming', $filters)) {
            $isUpcoming = $request->boolean('upcoming');
            $query->where(function ($query) use ($isUpcoming) {
                $query->where('custom_jadwal', $isUpcoming ? 1 : 0);

                if ($isUpcoming) {
                    $query->orWhere(function ($query) {
                        $query->whereNull('custom_jadwal')
                            ->where(function ($query) {
                                $query->whereDate('class_date', '>', today())
                                    ->orWhereDate('date_start', '>', today());
                            });
                    });
                }
            });
        }

        switch ($filters['sort'] ?? 'date') {
            case 'newest':
                $query->orderBy('id', $direction);
                break;
            case 'name':
                $query->orderBy('title', $direction);
                break;
            default:
                $query->orderByRaw("COALESCE(class_date, date_start, date_end) {$direction}")
                    ->orderBy('id', 'desc');
                break;
        }

        $classes = $query->paginate($filters['per_page'] ?? 15)->appends($request->query());

        return PublicClassResource::collection($classes)->additional([
            'success' => true,
            'message' => 'Daftar event dan kelas berhasil diambil.',
        ]);
    }

    public function ebooks(PublicCatalogRequest $request)
    {
        return $this->digitalContentResponse($request, 1, PublicEbookResource::class, 'Daftar ebook berhasil diambil.');
    }

    public function interactiveVideos(PublicCatalogRequest $request)
    {
        return $this->digitalContentResponse($request, 0, PublicInteractiveVideoResource::class, 'Daftar video interaktif berhasil diambil.');
    }

    private function digitalContentResponse(PublicCatalogRequest $request, int $itemType, string $resource, string $message)
    {
        $filters = $request->validated();
        $direction = $filters['direction'] ?? 'asc';

        $query = SubMateriModel::query()
            ->select([
                'id',
                'id_materi',
                'nama',
                'keterangan',
                'thumbnail',
                'urutan',
                'upcoming',
                'harga',
                'diskon',
                'harga_final',
                'created_at',
            ])
            ->whereHas('materi', function ($query) {
                $query->whereRaw('LOWER(nama) = ?', ['umum']);
            })
            ->whereHas('items', function ($query) use ($itemType) {
                $query->where('tipe_link_item', $itemType);
            })
            ->with([
                'materi:id,nama,banner,icon',
                'items' => function ($query) use ($itemType) {
                    $query->select(['id', 'id_sub_materi', 'judul_item', 'tipe_link_item'])
                        ->where('tipe_link_item', $itemType)
                        ->orderBy('id');
                },
            ]);

        if (! empty($filters['q'])) {
            $search = $filters['q'];
            $query->where(function ($query) use ($search) {
                $query->where('nama', 'like', "%{$search}%")
                    ->orWhere('keterangan', 'like', "%{$search}%");
            });
        }

        if (array_key_exists('upcoming', $filters)) {
            $query->where('upcoming', $request->boolean('upcoming') ? 1 : 0);
        }

        if (! empty($filters['tipe_harga'])) {
            if ($filters['tipe_harga'] === 'gratis') {
                $query->where(function ($query) {
                    $query->where(function ($query) {
                        $query->whereNull('harga_final')
                            ->where(function ($query) {
                                $query->whereNull('harga')->orWhere('harga', 0);
                            });
                    })->orWhere('harga_final', 0);
                });
            } else {
                $query->where(function ($query) {
                    $query->where('harga_final', '>', 0)
                        ->orWhere(function ($query) {
                            $query->whereNull('harga_final')->where('harga', '>', 0);
                        });
                });
            }
        }

        switch ($filters['sort'] ?? 'order') {
            case 'name':
                $query->orderBy('nama', $direction);
                break;
            case 'newest':
                $query->orderBy('created_at', $direction);
                break;
            default:
                $query->orderByRaw('COALESCE(upcoming, 0) ASC')
                    ->orderBy('urutan', $direction)
                    ->orderBy('id', 'desc');
                break;
        }

        $items = $query->paginate($filters['per_page'] ?? 15)->appends($request->query());

        return $resource::collection($items)->additional([
            'success' => true,
            'message' => $message,
        ]);
    }
}
