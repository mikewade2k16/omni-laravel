<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 * schema="CollectionItem",
 * type="object",
 * title="Collection Item",
 * description="Representa um item individual dentro de uma Coleção customizada.",
 * @OA\Property(property="id", type="integer", readOnly=true, description="ID único do item da coleção"),
 * @OA\Property(property="collection_id", type="integer", description="ID da coleção à qual este item pertence"),
 * @OA\Property(property="data", type="object", description="Objeto JSON com os dados do item, seguindo a estrutura definida no 'schema_json' da coleção pai.", example={"nome_completo": "Maria da Silva", "email": "maria.silva@example.com"} ),
 * @OA\Property(property="created_by", type="integer", description="ID do usuário que criou o item"),
 * @OA\Property(property="updated_by", type="integer", nullable=true, description="ID do usuário que realizou a última atualização do item"),
 * @OA\Property(property="created_at", type="string", format="date-time", readOnly=true, description="Data de criação"),
 * @OA\Property(property="updated_at", type="string", format="date-time", readOnly=true, description="Data da última atualização")
 * )
 */
class CollectionItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'collection_id',
        'data',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'data' => 'array', // armazena JSON como array
    ];

    /**
     * Item pertence a uma coleção.
     */
    public function collection()
    {
        return $this->belongsTo(Collection::class);
    }

    /**
     * Usuário que criou o item.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Usuário que atualizou o item.
     */
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
