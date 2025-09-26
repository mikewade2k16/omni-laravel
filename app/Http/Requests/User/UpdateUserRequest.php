<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules\Enum;
use App\Enums\UserStatusEnum;
use App\Enums\UserLevelEnum;
use App\Enums\UserTypeEnum;

class UpdateUserRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\ValidationRule|array<mixed>|string>
     */
    public function rules()
    {
        $userId = $this->route('id');

        return [
            'name' => 'sometimes|string|max:255',
            'email' => ['sometimes', 'string', 'email', 'max:255', Rule::unique('users')->ignore($userId)],
            'password' => 'sometimes|string|min:6|confirmed',
            'nick' => 'sometimes|string|max:50',
            'status' => ['sometimes', new Enum(UserStatusEnum::class)],
            'level' => ['sometimes', new Enum(UserLevelEnum::class)],
            'user_type' => ['sometimes', new Enum(UserTypeEnum::class)],
        ];
    }
}