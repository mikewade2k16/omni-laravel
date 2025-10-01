<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 * schema="SiteZen",
 * type="object",
 * title="Site Zen Analytics",
 * description="Modelo que representa as métricas consolidadas de um site, geralmente agrupadas por mês.",
 * @OA\Property(property="id", type="integer", readOnly=true, description="ID único do registro de métrica"),
 * @OA\Property(property="mes", type="string", description="Mês de referência das métricas", example="Janeiro"),
 * @OA\Property(property="visitas", type="integer", description="Número total de visitas ao site no mês", example=15000),
 * @OA\Property(property="compras", type="integer", description="Número total de compras realizadas no mês", example=300),
 * @OA\Property(property="novas_visitas", type="integer", description="Número de visitantes que acessaram o site pela primeira vez", example=9500),
 * @OA\Property(property="taxa_conversao", type="number", format="float", description="Taxa de conversão de visitas para compras (%)", example=2.0),
 * @OA\Property(property="ticket_medio", type="number", format="float", description="Valor médio gasto por compra", example=150.75),
 * @OA\Property(property="pa", type="number", format="float", description="Métrica de performance 'PA' (Produtos por Atendimento/Atração)", example=1.2),
 * @OA\Property(property="receita_total", type="number", format="float", description="Receita total gerada no mês", example=45225.00),
 * @OA\Property(property="produtos_mais_vistos", type="array", @OA\Items(type="string"), description="Lista dos nomes dos produtos mais visualizados", example={"Produto A", "Produto B", "Produto C"}),
 * @OA\Property(property="produtos_comprados", type="array", @OA\Items(type="string"), description="Lista dos nomes dos produtos mais comprados", example={"Produto A", "Produto D"}),
 * @OA\Property(property="funil_usuarios", type="array", description="Dados do funil de conversão de usuários", @OA\Items(type="object", @OA\Property(property="etapa", type="string", example="Homepage"),
 * @OA\Property(property="usuarios", type="integer", example=15000)
 * )
 * ),
 * @OA\Property(property="created_at", type="string", format="date-time", readOnly=true, description="Data de criação"),
 * @OA\Property(property="updated_at", type="string", format="date-time", readOnly=true, description="Data da última atualização")
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
        'visitas'              => 'integer',
        'compras'              => 'integer',
        'novas_visitas'        => 'integer',
        'taxa_conversao'       => 'float',
        'ticket_medio'         => 'float',
        'pa'                   => 'float',
        'receita_total'        => 'float',
        'produtos_mais_vistos' => 'array',
        'produtos_comprados'   => 'array',
        'funil_usuarios'       => 'array',
    ];
}
