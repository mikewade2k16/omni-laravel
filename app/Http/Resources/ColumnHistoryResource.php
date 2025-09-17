<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ColumnHistoryResource extends JsonResource
{
    public function toArray(Request $request): array
    {
        return [
            'id'          => $this->id,
            'task_id'     => $this->task_id,
            'old_column'  => new ColumnResource($this->whenLoaded('oldColumn')),
            'new_column'  => new ColumnResource($this->whenLoaded('newColumn')),
            'changed_at'  => $this->created_at->format('d/m/Y H:i:s'),
        ];
    }
}