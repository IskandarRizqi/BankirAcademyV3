<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class PublicLearningContentItemResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'title' => $this->judul_item,
            'link_item' => $this->link_item,
            'type' => (int) $this->tipe_link_item === 1 ? 'pdf' : 'video',
        ];
    }
}
