<?php

namespace App\Http\Resources;

use App\Models\ClassPricingModel;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Str;

class PublicClassResource extends JsonResource
{
    public function toArray($request): array
    {
        $pricing = $this->pricingData;

        return [
            'id' => $this->id,
            'slug' => $this->slug,
            'title' => $this->title,
            'category' => $this->category,
            'sub_category' => $this->decodeValue($this->sub_category),
            'tags' => $this->decodeValue($this->tags),
            'description' => $this->content ? Str::limit(trim(strip_tags($this->content)), 300) : null,
            'image_url' => $this->assetUrl($this->image),
            'image_mobile_url' => $this->assetUrl($this->image_mobile),
            'level' => (int) $this->level,
            'type' => $this->decodeValue($this->tipe),
            'kind' => $this->kategori,
            'is_iht' => (bool) $this->iht,
            'is_upcoming' => (int) $this->custom_jadwal === 1,
            'date_start' => $this->date_start,
            'date_end' => $this->date_end,
            'class_date' => $this->class_date,
            'pricing' => $this->pricing($pricing),
            'events' => PublicClassEventResource::collection($this->whenLoaded('classEvents')),
        ];
    }

    private function pricing(?ClassPricingModel $pricing): ?array
    {
        if (! $pricing) {
            return null;
        }

        $effectivePrice = $pricing->effectivePrice();

        return [
            'currency' => 'IDR',
            'price' => (float) $pricing->price,
            'effective_price' => $effectivePrice,
            'is_free' => $pricing->isFree() || $effectivePrice <= 0,
        ];
    }

    private function decodeValue($value)
    {
        if (! is_string($value)) {
            return $value;
        }

        $decoded = json_decode($value, true);

        return json_last_error() === JSON_ERROR_NONE ? $decoded : $value;
    }

    private function assetUrl(?string $path): ?string
    {
        if (! $path) {
            return null;
        }

        if (Str::startsWith($path, ['http://', 'https://', 'data:'])) {
            return $path;
        }

        return asset(ltrim($path, '/'));
    }
}
