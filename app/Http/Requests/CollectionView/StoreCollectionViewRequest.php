<?php

namespace App\Http\Requests\CollectionView;

use Illuminate\Foundation\Http\FormRequest;

class StoreCollectionViewRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'collection_id' => 'required|exists:collections,id',
            'name'          => 'required|string|max:255',
            'type'          => 'required|string|max:50',
            'config'        => 'nullable|array',
            'created_by'    => 'required|exists:users,id',
        ];
    }
}
