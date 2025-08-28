<?php

namespace App\Http\Requests\FilesOmni;

use Illuminate\Foundation\Http\FormRequest;

class UpdateFilesOmniRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'task_id' => 'nullable|exists:tasks,id',
            'client_id' => 'nullable|exists:clients,id',
            'uploaded_by' => 'nullable|exists:users,id',
            'file_path' => 'nullable|string',
            'file_name' => 'nullable|string',
            'file_type' => 'nullable|string',
            'version' => 'nullable|string',
            'cover_image' => 'nullable|string',
            'video_orientation' => 'nullable|string',
            'published' => 'nullable|boolean',
        ];
    }
}
