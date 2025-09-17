<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ShortLinkResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'         => $this->id,
            'slug'       => $this->slug,
            'target_url' => $this->target_url,
            'short_url'  => $this->short_url,
            'hits'       => $this->hits,
            'client'     => $this->client ? [
                'id'   => $this->client->id,
                'name' => $this->client->name,
            ] : null,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
