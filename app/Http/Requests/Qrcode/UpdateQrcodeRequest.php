<?php

namespace App\Http\Requests\Qrcode;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class UpdateQrcodeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'slug' => [
                'sometimes', 
                'string',
                'max:255',
                Rule::unique('qrcodes', 'slug')->ignore($this->route('qrcode')), 
            ],
            'target_url' => ['sometimes', 'nullable', 'url', 'max:2048'],
            'scan_count' => ['sometimes', 'integer', 'min:0'],
            'last_scanned_at' => ['sometimes', 'nullable', 'date'],
            'qr_image_path' => ['sometimes', 'nullable', 'string', 'max:255'],
            'is_active' => ['sometimes', 'boolean'],
            'client_id' => ['sometimes', 'nullable', 'exists:clients,id'],
            'created_by' => ['sometimes', 'exists:users,id'],
        ];
    }
}
