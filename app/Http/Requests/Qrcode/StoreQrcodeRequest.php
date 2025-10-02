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
            'slug' => 'required|string|max:255|unique:qrcodes,slug',
            'target_url' => 'required|url|max:2048',
            'scan_count' => 'required|integer|min:0',
            'last_scanned_at' => 'nullable|date',
            'qr_image_path' => 'nullable|string|max:255',
            'is_active' => 'required|boolean',
            'client_id' => 'nullable|exists:clients,id',
            // 'created_by' => 'required|exists:users,id',
        ];
    }
}
