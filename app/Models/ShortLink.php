<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 * schema="ShortLink",
 * type="object",
 * title="Short Link",
 * description="Representa um link encurtado com rastreamento de cliques.",
 * @OA\Property(property="id", type="integer", readOnly=true, description="ID único do link encurtado"),
 * @OA\Property(property="slug", type="string", description="O código curto e único gerado para o link", example="aB1cD2eF"),
 * @OA\Property(property="target_url", type="string", format="url", description="A URL de destino original e longa", example="https://uma-url-muito-longa-para-uma-campanha-especifica.com/landing-page"),
 * @OA\Property(property="short_url", type="string", format="url", description="A URL encurtada completa, pronta para ser compartilhada", example="https://meu.site/aB1cD2eF"),
 * @OA\Property(property="client_id", type="integer", nullable=true, description="ID do cliente associado a este link (opcional)"),
 * @OA\Property(property="hits", type="integer", description="Número de cliques que o link recebeu", example=542),
 * @OA\Property(property="created_at", type="string", format="date-time", readOnly=true, description="Data de criação"),
 * @OA\Property(property="updated_at", type="string", format="date-time", readOnly=true, description="Data da última atualização")
 * )
 */
class ShortLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'target_url',
        'short_url',
        'client_id',
        'hits',
    ];

    protected $casts = [
        'hits' => 'integer',
    ];

    /**
     * ShortLink pertence a um cliente (opcional).
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
