<?php

namespace App\Http\Requests\SiteZen;

use Illuminate\Foundation\Http\FormRequest;

class UpdateSiteZenRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'mes' => 'sometimes|string|max:50',
            'visitas' => 'sometimes|integer',
            'compras' => 'sometimes|integer',
            'novas_visitas' => 'sometimes|integer',
            'taxa_conversao' => 'sometimes|numeric',
            'ticket_medio' => 'sometimes|numeric',
            'pa' => 'sometimes|numeric',
            'receita_total' => 'sometimes|numeric',
            'produtos_mais_vistos' => 'nullable|array',
            'produtos_comprados' => 'nullable|array',
            'funil_usuarios' => 'nullable|array',
        ];
    }
}
