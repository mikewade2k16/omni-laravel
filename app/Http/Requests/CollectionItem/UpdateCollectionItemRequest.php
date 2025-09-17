<?php

namespace App\Http\Requests\CollectionItem;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCollectionItemRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'collection_id' => 'sometimes|exists:collections,id',
            'data' => 'sometimes|array',
            //'updated_by' => 'required|exists:users,id',
        ];
    }
}
