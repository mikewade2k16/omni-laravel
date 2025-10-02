<?php

namespace App\Http\Requests\Project;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use App\Enums\ProjectStatusEnum;

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
            'status' => ['required', new Enum(ProjectStatusEnum::class)],
            'visibility'   => 'required|string|in:public,private',
            'members'      => 'nullable|array',                    
            'members.*'    => 'integer|exists:users,id',   
            'type_project' => 'nullable|string|max:50',
            'link' => 'nullable|url|max:255',
            'goal' => 'nullable|string|max:255',
            'description' => 'nullable|string',
            'date_project' => 'nullable|date',
            'category' => 'nullable|string|max:100',
            'segment' => 'nullable|string|max:100',
            'settings' => ['nullable', 'array'],
            'settings.view_type' => ['sometimes', 'string', 'in:card,list'],
        ];
    }
}
