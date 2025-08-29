<?php

namespace App\Http\Requests\UserProject;

use Illuminate\Foundation\Http\FormRequest;

class StoreUserProjectRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'user_id' => 'required|integer|exists:users,id',
            'project_id' => 'required|integer|exists:projects,id',
        ];
    }

}
