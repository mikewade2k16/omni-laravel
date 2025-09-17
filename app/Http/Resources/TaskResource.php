<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class TaskResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id'           => $this->id,
            'client_id'    => $this->client_id,
            'campaign_id'  => $this->campaign_id,
            'user_id'      => $this->user_id,
            'name'         => $this->name,
            'status'       => $this->status,
            'type_task'    => $this->type_task,
            'number'       => $this->number,
            'description'  => $this->description,
            'comment'      => $this->comment,
            'start_date'   => $this->start_date?->toDateString(),
            'due_date'     => $this->due_date?->toDateString(),
            'priority'     => $this->priority,
            'file'         => $this->file,
            'archived'     => $this->archived,
            'order_position' => $this->order_position,
            'involved_users' => $this->involved_users,
            'timer_status'   => $this->timer_status,
            'last_started'   => $this->last_started?->toDateTimeString(),
            'time_spent'     => $this->time_spent,
            'created_at'     => $this->created_at->toDateTimeString(),
            'updated_at'     => $this->updated_at->toDateTimeString(),
        ];
    }
}
