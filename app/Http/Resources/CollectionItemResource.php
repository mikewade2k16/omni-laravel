<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CollectionItemResource extends JsonResource
{
    public function toArray($request): array
    {
        $response = [
            'id' => $this->id,
            'collection_id' => $this->collection_id,
            'data' => $this->data,
            'created_by' => $this->created_by,
            'updated_by' => $this->updated_by,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];

        dd($response);

        return $response;
    }
}
