<?php

namespace App\Http\Requests\CollectionView;

use Illuminate\Foundation\Http\FormRequest;

class UpdateCollectionViewRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'name'   => 'sometimes|string|max:255',
            'type'   => 'sometimes|string|max:50',
            'config' => 'nullable|array',
        ];
    }
}
