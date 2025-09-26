<?php

namespace App\Http\Requests\User;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use App\Enums\UserStatusEnum;
use App\Enums\UserLevelEnum;
use App\Enums\UserTypeEnum;

class StoreUserRequest extends FormRequest
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
        return [
            'name'      => 'required|string|max:255',
            'email'     => 'required|string|email|max:255|unique:users,email',
            'password'  => 'required|string|min:6|confirmed',
            'nick'      => 'required|string|max:50',
            'status'    => ['required', new Enum(UserStatusEnum::class)],
            'level'     => ['required', new Enum(UserLevelEnum::class)],
            'user_type' => ['required', new Enum(UserTypeEnum::class)],
        ];
    }
}