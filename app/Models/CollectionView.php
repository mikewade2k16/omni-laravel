<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 * schema="CollectionView",
 * type="object",
 * title="Collection View",
 * description="Representa uma visualização salva (ex: tabela, kanban) para uma coleção de dados.",
 * @OA\Property(property="id", type="integer", readOnly=true, description="ID único da visualização"),
 * @OA\Property(property="collection_id", type="integer", description="ID da coleção à qual esta visualização pertence", example=1),
 * @OA\Property(property="name", type="string", description="Nome da visualização", example="Visão de Tabela Padrão"),
 * @OA\Property(property="type", type="string", enum={"table", "kanban", "calendar"}, description="Tipo de visualização", example="kanban"),
 * @OA\Property(property="created_by", type="integer", description="ID do usuário que criou a visualização", example=1),
 * @OA\Property(
 * property="config",
 * type="object",
 * description="Configurações JSON da visualização, como colunas visíveis, filtros e ordenação.",
 * @OA\Property(
 * property="columns",
 * type="array",
 * @OA\Items(type="string"),
 * example={"id", "name", "due_date"}
 * ),
 * @OA\Property(
 * property="filter",
 * type="object",
 * @OA\Property(property="status", type="string", example="active")
 * ),
 * @OA\Property(property="sort_by", type="string", example="due_date")
 * ),
 * @OA\Property(property="created_at", type="string", format="date-time", readOnly=true, description="Data de criação"),
 * @OA\Property(property="updated_at", type="string", format="date-time", readOnly=true, description="Data da última atualização")
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
        'config' => 'array',
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

