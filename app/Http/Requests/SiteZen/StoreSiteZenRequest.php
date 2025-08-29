<?php

namespace App\Http\Requests\SiteZen;

use Illuminate\Foundation\Http\FormRequest;

class StoreSiteZenRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'mes' => 'required|string|max:50',
            'visitas' => 'required|integer',
            'compras' => 'required|integer',
            'novas_visitas' => 'required|integer',
            'taxa_conversao' => 'required|numeric',
            'ticket_medio' => 'required|numeric',
            'pa' => 'required|numeric',
            'receita_total' => 'required|numeric',
            'produtos_mais_vistos' => 'nullable|array',
            'produtos_comprados' => 'nullable|array',
            'funil_usuarios' => 'nullable|array',
        ];
    }
}
