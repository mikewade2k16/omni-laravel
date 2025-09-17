<?php

namespace App\Http\Requests\ShortLink;

use Illuminate\Foundation\Http\FormRequest;

class UpdateShortLinkRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $shortLinkId = $this->route('shortLink');

        return [
            'slug'       => "required|string|unique:short_links,slug,$shortLinkId",
            'target_url' => 'required|url',
            'short_url'  => 'required|url',
            'client_id'  => 'nullable|exists:clients,id',
            'hits'       => 'nullable|integer',
        ];
    }
}
