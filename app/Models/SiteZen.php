<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class SiteZen extends Model
{
    use HasFactory;

    protected $fillable = [
        'mes',
        'visitas',
        'compras',
        'novas_visitas',
        'taxa_conversao',
        'ticket_medio',
        'pa',
        'receita_total',
        'produtos_mais_vistos',
        'produtos_comprados',
        'funil_usuarios',
    ];

    protected $casts = [
        'visitas'             => 'integer',
        'compras'             => 'integer',
        'novas_visitas'       => 'integer',
        'taxa_conversao'      => 'float',
        'ticket_medio'        => 'float',
        'pa'                  => 'float',
        'produtos_mais_vistos' => 'array', // se armazenar JSON
        'produtos_comprados'  => 'array', // se armazenar JSON
        'funil_usuarios'      => 'array', // se armazenar JSON
    ];
}
