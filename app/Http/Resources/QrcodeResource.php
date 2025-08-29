<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class QrcodeResource extends JsonResource
{
    public function toArray($request): array
    {
        return [
            'id'              => $this->id,
            'slug'            => $this->slug,
            'target_url'      => $this->target_url,
            'scan_count'      => $this->scan_count,
            'last_scanned_at' => $this->last_scanned_at?->toDateTimeString(),
            'qr_image_url'    => $this->qr_image_path ? asset('storage/'.$this->qr_image_path) : null,
            'is_active'       => $this->is_active,

            // Relações
            'client'   => new ClientResource($this->whenLoaded('client')),
            'creator'  => new UserResource($this->whenLoaded('creator')),

            'created_at' => $this->created_at->toDateTimeString(),
            'updated_at' => $this->updated_at->toDateTimeString(),
        ];
    }
}
