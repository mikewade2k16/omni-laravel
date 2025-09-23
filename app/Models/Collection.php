<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 * schema="Collection",
 * type="object",
 * title="Collection",
 * properties={
 * @OA\Property(property="id", type="integer"),
 * @OA\Property(property="name", type="string", description="Nome da coleção"),
 * @OA\Property(property="slug", type="string", description="URL amigável da coleção"),
 * @OA\Property(property="client_id", type="integer", nullable=true, description="ID do cliente associado"),
 * @OA\Property(property="owner_id", type="integer", description="ID do usuário dono da coleção"),
 * @OA\Property(property="visibility", type="string", example="public"),
 * @OA\Property(property="agency_access", type="boolean", description="Se a agência tem acesso"),
 * @OA\Property(property="description", type="string", nullable=true),
 * @OA\Property(property="schema_json", type="object", description="Estrutura JSON dos campos da coleção"),
 * @OA\Property(property="created_at", type="string", format="date-time"),
 * @OA\Property(property="updated_at", type="string", format="date-time")
 * }
 * )
 */
class Collection extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'slug',
        'client_id',
        'owner_id',
        'visibility',
        'agency_access',
        'icon',
        'description',
        'schema_json',
    ];

    protected $casts = [
        'agency_access' => 'boolean',
        'schema_json'   => 'array',
    ];

    /**
     * Relacionamento com o cliente (se houver).
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Relacionamento com o dono (usuário que criou).
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
}
