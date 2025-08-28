<?php

namespace App\Http\Requests\FilesOmni;

use Illuminate\Foundation\Http\FormRequest;

class StoreFilesOmniRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'task_id' => 'nullable|exists:tasks,id',
            'client_id' => 'required|exists:clients,id',
            'uploaded_by' => 'required|exists:users,id',
            'file_path' => 'required|string',
            'file_name' => 'required|string',
            'file_type' => 'required|string',
            'version' => 'nullable|string',
            'cover_image' => 'nullable|string',
            'video_orientation' => 'nullable|string',
            'published' => 'boolean',
        ];
    }
}
