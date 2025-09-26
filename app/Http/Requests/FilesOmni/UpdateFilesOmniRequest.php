<?php

namespace App\Http\Requests\FilesOmni;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use App\Enums\FilesOmniVersionEnum;
use App\Enums\FilesOmniVideoOrientationEnum;

class UpdateFilesOmniRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'task_id'       => 'sometimes|exists:tasks,id',
            'client_id'     => 'sometimes|exists:clients,id',
            'uploaded_by'   => 'sometimes|exists:users,id',
            'file_path'     => 'sometimes|string',
            'file_name'     => 'sometimes|string',
            'file_type'     => 'sometimes|string',
            'version'       => ['sometimes', new Enum(FilesOmniVersionEnum::class)],
            'video_orientation' => ['sometimes', 'nullable', new Enum(FilesOmniVideoOrientationEnum::class)],
            'cover_image'   => 'sometimes|string',
            'published'     => 'sometimes|boolean',
        ];
    }
}
