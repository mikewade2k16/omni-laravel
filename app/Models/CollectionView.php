<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 * schema="CollectionView",
 * type="object",
 * title="Collection View",
 * properties={
 * @OA\Property(property="id", type="integer"),
 * @OA\Property(property="collection_id", type="integer"),
 * @OA\Property(property="name", type="string", description="Nome da visualização"),
 * @OA\Property(property="type", type="string", description="Tipo de visualização (ex: 'table', 'kanban')"),
 * @OA\Property(property="config", type="object", description="Configurações da view em formato JSON"),
 * @OA\Property(property="created_by", type="integer", description="ID do usuário que criou a view"),
 * @OA\Property(property="created_at", type="string", format="date-time"),
 * @OA\Property(property="updated_at", type="string", format="date-time")
 * }
 * )
 */
class CollectionView extends Model
{
    use HasFactory;

    protected $fillable = [
        'collection_id',
        'name',
        'type',
        'config',
        'created_by',
    ];

    protected $casts = [
        'config' => 'array', // converte JSON armazenado em array automaticamente
    ];

    /**
     * View pertence a uma coleção.
     */
    public function collection()
    {
        return $this->belongsTo(Collection::class);
    }

    /**
     * Usuário que criou a view.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
