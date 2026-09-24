<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

abstract class PublicLearningContentResource extends JsonResource
{
    protected $contentType;

    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'type' => $this->contentType,
            'title' => $this->nama,
            'description' => $this->keterangan ? Str::limit(strip_tags($this->keterangan), 300) : null,
            'thumbnail_url' => $this->thumbnailUrl($this->thumbnail),
            'is_upcoming' => (bool) $this->upcoming,
            'pricing' => [
                'currency' => 'IDR',
                'price' => (float) ($this->harga ?? 0),
                'discount_percent' => (float) ($this->diskon ?? 0),
                'final_price' => (float) ($this->harga_final ?? $this->harga ?? 0),
                'is_free' => (float) ($this->harga_final ?? $this->harga ?? 0) <= 0,
            ],
            'parent' => $this->materi ? [
                'id' => $this->materi->id,
                'name' => $this->materi->nama,
            ] : null,
            'items' => PublicLearningContentItemResource::collection($this->whenLoaded('items')),
        ];
    }

    private function thumbnailUrl(?string $path): ?string
    {
        if (! $path) {
            return null;
        }

        if (Str::startsWith($path, ['http://', 'https://', 'data:'])) {
            return $path;
        }

        if (Str::startsWith($path, 'photos/')) {
            return Storage::disk('public')->url($path);
        }

        return asset(ltrim($path, '/'));
    }
}
