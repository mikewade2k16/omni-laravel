<?php

namespace App\Http\Requests\Campaign;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rules\Enum;
use App\Enums\CampaignStatusEnum;

class UpdateCampaignRequest extends FormRequest
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
            'client_id' => 'required|integer|exists:clients,id',
            'name'      => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_date' => 'nullable|date',
            'end_date'   => 'nullable|date',
            'banner_image' => 'nullable|string|max:255',
            'status' => ['sometimes', new Enum(CampaignStatusEnum::class)],
            'channels'    => 'nullable|array',
        ];
    }
}
