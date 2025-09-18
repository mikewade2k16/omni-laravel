<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use App\Http\Resources\ColumnResource; 
use App\Http\Resources\UserResource;   

class TaskResource extends JsonResource
{

    public function toArray(Request $request): array
    {
        return [
            'id'             => $this->id,
            'client_id'      => $this->client_id,
            'campaign_id'    => $this->campaign_id,
            'user_id'        => $this->user_id,
            'name'           => $this->name,
            'type_task'      => $this->type_task,
            'number'         => $this->number,
            'description'    => $this->description,
            'comment'        => $this->comment,
            'start_date'     => $this->start_date?->toDateString(),
            'due_date'       => $this->due_date?->toDateString(),
            'priority'       => $this->priority,
            'file'           => $this->file,
            'archived'       => $this->archived,
            'order_position' => $this->order_position,
            'timer_status'   => $this->timer_status,
            'last_started'   => $this->last_started?->toDateTimeString(),
            'time_spent'     => $this->time_spent,
            'created_at'     => $this->created_at->toDateTimeString(),
            'updated_at'     => $this->updated_at->toDateTimeString(),
            'column'         => new ColumnResource($this->whenLoaded('column')),
            'users'          => UserResource::collection($this->whenLoaded('users')),
        ];
    }
}