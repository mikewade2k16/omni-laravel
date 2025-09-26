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
 * properties={
 * @OA\Property(property="id", type="integer"),
 * @OA\Property(property="client_id", type="integer"),
 * @OA\Property(property="name", type="string"),
 * @OA\Property(property="description", type="string"),
 * @OA\Property(property="start_date", type="string", format="date", example="2025-01-30"),
 * @OA\Property(property="end_date", type="string", format="date", example="2025-02-28"),
 * @OA\Property(property="status", type="string", example="active"),
 * @OA\Property(property="channels", type="array", @OA\Items(type="string"), example={"facebook", "instagram"}),
 * @OA\Property(property="created_at", type="string", format="date-time"),
 * @OA\Property(property="updated_at", type="string", format="date-time")
 * }
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
