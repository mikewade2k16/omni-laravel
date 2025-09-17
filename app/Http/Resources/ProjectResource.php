<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ProjectResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id' => $this->id,
            'client_id' => $this->client_id,
            'name' => $this->name,
            'status' => $this->status,
            'type_project' => $this->type_project,
            'link' => $this->link,
            'goal' => $this->goal,
            'description' => $this->description,
            'date_project' => $this->date_project,
            'category' => $this->category,
            'segment' => $this->segment,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
