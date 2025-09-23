<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 * schema="ShortLink",
 * type="object",
 * title="Short Link",
 * properties={
 * @OA\Property(property="id", type="integer"),
 * @OA\Property(property="slug", type="string", description="O código curto gerado para o link"),
 * @OA\Property(property="target_url", type="string", format="url", description="A URL de destino original"),
 * @OA\Property(property="short_url", type="string", format="url", description="A URL encurtada completa"),
 * @OA\Property(property="client_id", type="integer", nullable=true, description="ID do cliente associado"),
 * @OA\Property(property="hits", type="integer", description="Número de cliques que o link recebeu"),
 * @OA\Property(property="created_at", type="string", format="date-time"),
 * @OA\Property(property="updated_at", type="string", format="date-time")
 * }
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
