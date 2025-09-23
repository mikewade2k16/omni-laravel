<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 * schema="SiteZen",
 * type="object",
 * title="Site Zen Analytics",
 * description="Modelo que representa as métricas mensais de um site",
 * properties={
 * @OA\Property(property="id", type="integer"),
 * @OA\Property(property="mes", type="string", example="Janeiro"),
 * @OA\Property(property="visitas", type="integer", example=15000),
 * @OA\Property(property="compras", type="integer", example=300),
 * @OA\Property(property="taxa_conversao", type="number", format="float", example=2.5),
 * @OA\Property(property="ticket_medio", type="number", format="float", example=150.75),
 * @OA\Property(property="receita_total", type="number", format="float", example=45225.00),
 * @OA\Property(property="produtos_mais_vistos", type="array", @OA\Items(type="string"), example={"Produto A", "Produto B"}),
 * @OA\Property(property="created_at", type="string", format="date-time"),
 * @OA\Property(property="updated_at", type="string", format="date-time")
 * }
 * )
 */
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
        'produtos_mais_vistos' => 'array',
        'produtos_comprados'  => 'array', 
        'funil_usuarios'      => 'array', 
    ];
}
