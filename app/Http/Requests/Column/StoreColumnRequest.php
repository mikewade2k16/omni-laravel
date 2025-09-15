<?php

namespace App\Http\Requests\Column;

use Illuminate\Foundation\Http\FormRequest;

class StoreColumnRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true; // Ou adicione sua lógica de autorização
    }

    public function rules(): array
    {
        return [
            'project_id' => ['required', 'integer', 'exists:projects,id'],
            'name'       => ['required', 'string', 'max:255'],
        ];
    }
}