<?php

namespace App\Http\Requests\Collection;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCollectionRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $collectionId = $this->route('id');

        return [
            'name'          => 'sometimes|required|string|max:255',
            'slug'          => "sometimes|required|string|max:255|unique:collections,slug,{$collectionId}",
            'client_id'     => 'nullable|integer|exists:clients,id',
            'owner_id'      => 'sometimes|required|integer|exists:users,id',
            'visibility'    => 'sometimes|required|string|in:public,private',
            'agency_access' => 'boolean',
            'icon'          => 'nullable|string|max:255',
            'description'   => 'nullable|string',
            'schema_json'   => 'nullable|array',
        ];
    }
}
