<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CampaignResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'          => $this->id,
            'client_id'   => $this->client_id,
            'name'        => $this->name,
            'description' => $this->description,
            'start_date'  => $this->start_date?->toDateString(),
            'end_date'    => $this->end_date?->toDateString(),
            'status'      => $this->status,
            'channels'    => $this->channels,
        ];
    }
}
