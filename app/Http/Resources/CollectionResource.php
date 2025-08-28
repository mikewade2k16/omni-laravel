<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CollectionResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'slug' => $this->slug,
            'client_id' => $this->client_id,
            'owner_id' => $this->owner_id,
            'visibility' => $this->visibility,
            'agency_access' => $this->agency_access,
            'icon' => $this->icon,
            'description' => $this->description,
            'schema_json' => $this->schema_json,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
