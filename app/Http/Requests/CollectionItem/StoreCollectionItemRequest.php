<?php

namespace App\Http\Requests\CollectionItem;

use Illuminate\Foundation\Http\FormRequest;

class StoreCollectionItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'collection_id' => 'required|exists:collections,id',
            'data' => 'required|array',
            'created_by' => 'required|exists:users,id',
        ];
    }
}
