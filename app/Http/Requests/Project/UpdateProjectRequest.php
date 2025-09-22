<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;

class UpdateProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'client_id' => 'sometimes|integer|exists:clients,id',
            'name' => 'sometimes|string|max:255',
            'status' => 'sometimes|string|max:50',
            'visibility'   => 'sometimes|string|in:public,private',
            'members'      => 'sometimes|array',                   
            'members.*'    => 'sometimes|exists:users,id',   
            'type_project' => 'sometimes|string|max:50',
            'link' => 'nullable|url|max:255',
            'goal' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'date_project' => 'sometimes|date',
            'category' => 'nullable|string|max:100',
            'segment' => 'nullable|string|max:100',
        ];
    }
}
