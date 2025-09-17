<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CollectionViewResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'           => $this->id,
            'collection_id'=> $this->collection_id,
            'name'         => $this->name,
            'type'         => $this->type,
            'config'       => $this->config,
            'created_by'   => $this->created_by,
            'created_at'   => $this->created_at,
            'updated_at'   => $this->updated_at,
        ];
    }
}
