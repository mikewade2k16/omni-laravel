<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 * schema="Collection",
 * type="object",
 * title="Collection",
 * description="Modelo de Coleção de Dados customizável",
 * @OA\Property(property="id", type="integer", readOnly=true, description="ID único da coleção"),
 * @OA\Property(property="name", type="string", description="Nome da coleção", example="Leads de Marketing"),
 * @OA\Property(property="slug", type="string", description="URL amigável da coleção (geralmente gerado a partir do nome)", example="leads-de-marketing"),
 * @OA\Property(property="client_id", type="integer", nullable=true, description="ID do cliente ao qual esta coleção está associada (opcional)"),
 * @OA\Property(property="owner_id", type="integer", description="ID do usuário que é dono da coleção", example=1),
 * @OA\Property(property="visibility", type="string", description="Define quem pode ver a coleção", enum={"public", "private", "unlisted"}, example="public"),
 * @OA\Property(property="agency_access", type="boolean", description="Indica se a agência tem acesso a esta coleção", example=true),
 * @OA\Property(property="icon", type="string", nullable=true, description="Ícone associado à coleção (ex: nome do ícone de uma biblioteca ou URL)", example="fa-users"),
 * @OA\Property(property="description", type="string", nullable=true, description="Descrição detalhada sobre o propósito da coleção"),
 * @OA\Property(property="schema_json", type="object", description="Estrutura JSON que define os campos customizados da coleção", example={"fields": {{"name": "nome_completo", "type": "string", "required": true}, {"name": "email", "type": "email", "required": true}}}),
 * @OA\Property(property="created_at", type="string", format="date-time", readOnly=true, description="Data de criação"),
 * @OA\Property(property="updated_at", type="string", format="date-time", readOnly=true, description="Data da última atualização")
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
