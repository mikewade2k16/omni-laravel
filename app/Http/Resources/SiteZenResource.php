<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class SiteZenResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'mes' => $this->mes,
            'visitas' => $this->visitas,
            'compras' => $this->compras,
            'novas_visitas' => $this->novas_visitas,
            'taxa_conversao' => $this->taxa_conversao,
            'ticket_medio' => $this->ticket_medio,
            'pa' => $this->pa,
            'receita_total' => $this->receita_total,
            'produtos_mais_vistos' => $this->produtos_mais_vistos,
            'produtos_comprados' => $this->produtos_comprados,
            'funil_usuarios' => $this->funil_usuarios,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
