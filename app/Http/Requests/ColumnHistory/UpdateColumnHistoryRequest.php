<?php

namespace App\Http\Requests\ColumnHistory;

use Illuminate\Foundation\Http\FormRequest;

class UpdateColumnHistoryRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Ou adicione sua lógica de autorização
    }

    public function rules(): array
    {
        return [
            'task_id'       => ['sometimes', 'integer', 'exists:tasks,id'],
            'old_column_id' => ['sometimes', 'nullable', 'integer', 'exists:columns,id'],
            'new_column_id' => ['sometimes', 'integer', 'exists:columns,id'],
        ];
    }
}   