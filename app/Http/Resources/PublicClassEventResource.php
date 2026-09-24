<?php

namespace App\Http\Resources;

use Carbon\Carbon;
use Illuminate\Http\Resources\Json\JsonResource;

class PublicClassEventResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'type' => (int) $this->type === 1 ? 'offline' : 'online',
            'location' => $this->location,
            'description' => $this->description,
            'time_start' => $this->formatDateTime($this->time_start),
            'time_end' => $this->formatDateTime($this->time_end),
        ];
    }

    private function formatDateTime($value): ?string
    {
        return $value ? Carbon::parse($value)->toIso8601String() : null;
    }
}
