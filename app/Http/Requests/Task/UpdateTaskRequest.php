<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTaskRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'client_id'    => 'sometimes|integer',
            'campaign_id'  => 'sometimes|integer',
            'user_id'      => 'sometimes|integer',
            'name'         => 'sometimes|string|max:255',
            'status'       => 'sometimes|string|max:50',
            'type_task'    => 'sometimes|string|max:50',
            'number'       => 'sometimes|integer',
            'description'  => 'sometimes|string',
            'comment'      => 'sometimes|string',
            'start_date'   => 'sometimes|date',
            'due_date'     => 'sometimes|date',
            'priority'     => 'sometimes|integer',
            'file'         => 'sometimes|string',
            'archived'     => 'sometimes|boolean',
            'order_position' => 'sometimes|integer',
            'involved_users' => 'sometimes|array',
            'timer_status'   => 'sometimes|integer',
            'last_started'   => 'sometimes|date',
            'time_spent'     => 'sometimes|integer',
        ];
    }
}
