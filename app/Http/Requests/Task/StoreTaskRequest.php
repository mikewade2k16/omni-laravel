<?php

namespace App\Http\Requests\Task;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use App\Enums\TaskTypeEnum;

class StoreTaskRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'client_id'      => 'nullable|integer',
            'campaign_id'    => 'nullable|integer',
            'user_id'        => 'nullable|integer',
            'name'           => 'required|string|max:255',
            'column_id'      => 'nullable|integer|exists:columns,id',
            // 'status'      => 'nullable|string|max:50',
            'type_task' => ['nullable', new Enum(TaskTypeEnum::class)],
            'number'         => 'nullable|integer',
            'description'    => 'nullable|string',
            'comment'        => 'nullable|string',
            'start_date'     => 'nullable|date',
            'due_date'       => 'nullable|date',
            'priority'       => 'nullable|integer',
            'file'           => 'nullable|string',
            'archived'       => 'nullable|boolean',
            'order_position' => 'nullable|integer',
            'involved_users' => 'nullable|array',
            'timer_status'   => 'nullable|integer',
            'last_started'   => 'nullable|date',
            'time_spent'     => 'nullable|integer',
        ];
    }
}