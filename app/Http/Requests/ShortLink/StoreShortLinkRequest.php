<?php

namespace App\Http\Requests\ShortLink;

use Illuminate\Foundation\Http\FormRequest;

class StoreShortLinkRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'slug'       => 'required|string|unique:short_links,slug',
            'target_url' => 'required|url',
            'short_url'  => 'required|url',
            'client_id'  => 'nullable|exists:clients,id',
            'hits'       => 'nullable|integer',
        ];
    }
}
