<?php

namespace App\Http\Requests\Qrcode;

use Illuminate\Foundation\Http\FormRequest;

class StoreQrcodeRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules()
    {
        return [
            'slug' => 'required|unique:qrcodes,slug',
            'target_url' => 'required|url',
            'qr_image_path' => 'nullable|string',
            'is_active' => 'boolean',
            'client_id' => 'nullable|exists:clients,id',
            'created_by' => 'required|exists:users,id',
        ];
    }
}
