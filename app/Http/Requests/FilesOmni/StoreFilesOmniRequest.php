<?php

namespace App\Http\Requests\FilesOmni;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use App\Enums\FilesOmniVersionEnum;
use App\Enums\FilesOmniVideoOrientationEnum;

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
            'client_id' => 'nullable|exists:clients,id',
            'uploaded_by' => 'required|exists:users,id',
            'file_path' => 'required|string',
            'file_name' => 'required|string',
            'file_type' => 'required|string',
            'version' => ['required', new Enum(FilesOmniVersionEnum::class)],
            'video_orientation' => ['nullable', new Enum(FilesOmniVideoOrientationEnum::class)],
            'cover_image' => 'nullable|string',
            'published' => 'boolean',
        ];
    }
}
