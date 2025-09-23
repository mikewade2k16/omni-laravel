<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 * schema="CollectionItem",
 * type="object",
 * title="Collection Item",
 * properties={
 * @OA\Property(property="id", type="integer"),
 * @OA\Property(property="collection_id", type="integer"),
 * @OA\Property(property="data", type="object", description="Dados flexíveis em formato JSON"),
 * @OA\Property(property="created_by", type="integer", description="ID do usuário que criou o item"),
 * @OA\Property(property="updated_by", type="integer", description="ID do usuário que atualizou o item"),
 * @OA\Property(property="created_at", type="string", format="date-time"),
 * @OA\Property(property="updated_at", type="string", format="date-time")
 * }
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
