<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'client_id' => 'required|integer|exists:clients,id',
            'name' => 'required|string|max:255',
            'status' => 'required|string|max:50',
            'visibility'   => 'sometimes|string|in:public,private',
            'members'      => 'nullable|array',                    
            'members.*'    => 'integer|exists:users,id',   
            'type_project' => 'required|string|max:50',
            'link' => 'nullable|url|max:255',
            'goal' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'date_project' => 'required|date',
            'category' => 'nullable|string|max:100',
            'segment' => 'nullable|string|max:100',
        ];
    }
}
