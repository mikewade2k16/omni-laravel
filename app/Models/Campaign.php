<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\CampaignStatusEnum;

/**
 * @OA\Schema(
 * schema="Campaign",
 * type="object",
 * title="Campaign",
 * description="Modelo de Campanha de Marketing",
 * @OA\Property(property="id", type="integer", readOnly=true, description="ID único da campanha"),
 * @OA\Property(property="client_id", type="integer", description="ID do cliente ao qual a campanha pertence"),
 * @OA\Property(property="name", type="string", description="Nome da campanha", example="Promoção de Verão"),
 * @OA\Property(property="description", type="string", description="Descrição detalhada da campanha"),
 * @OA\Property(property="start_date", type="string", format="date", description="Data de início da campanha (AAAA-MM-DD)", example="2025-01-30"),
 * @OA\Property(property="end_date", type="string", format="date", description="Data de término da campanha (AAAA-MM-DD)", example="2025-02-28"),
 * @OA\Property(property="banner_image", type="string", nullable=true, description="URL da imagem do banner da campanha"),
 * @OA\Property(property="status", type="string", description="Status atual da campanha", enum={"ativa", "em_pausa", "concluida", "cancelada"}, example="ativa"),
 * @OA\Property(property="channels", type="array", description="Canais de veiculação da campanha",
 * @OA\Items(type="string"), example={"facebook", "instagram", "google_ads"}),
 * @OA\Property(property="created_at", type="string", format="date-time", readOnly=true, description="Data de criação"),
 * @OA\Property(property="updated_at", type="string", format="date-time", readOnly=true, description="Data da última atualização")
 * )
 */
class Campaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'name',
        'description',
        'start_date',
        'end_date',
        'banner_image',
        'status',
        'channels',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
        'channels'   => 'array',
        'status' => CampaignStatusEnum::class,
    ];

    /**
     * Uma campanha pertence a um cliente.
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
