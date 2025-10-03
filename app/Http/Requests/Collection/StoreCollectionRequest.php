<?php

namespace App\Http\Requests\Collection;

use Illuminate\Foundation\Http\FormRequest;

class StoreCollectionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'          => 'required|string|max:255',
            'slug'          => 'nullable|string|max:255|unique:collections,slug',
            'client_id'     => 'nullable|integer|exists:clients,id',
            'owner_id'      => 'nullable|integer|exists:users,id',
            'visibility'    => 'required|string|in:public,private',
            'agency_access' => 'boolean',
            'icon'          => 'nullable|string|max:255',
            'description'   => 'nullable|string',
            'schema_json'   => 'nullable|array',
        ];
    }
}
