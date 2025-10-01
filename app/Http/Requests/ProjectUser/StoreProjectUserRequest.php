<?php

namespace App\Http\Requests\ProjectUser;

use Illuminate\Foundation\Http\FormRequest;

class StoreProjectUserRequest extends FormRequest
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
