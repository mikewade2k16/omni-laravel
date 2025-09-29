<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
/**
 * @OA\Schema(
 * schema="Column",
 * type="object",
 * title="Column",
 * description="Representa uma coluna (ou estágio) dentro de um projeto Kanban.",
 * @OA\Property(property="id", type="integer", readOnly=true, description="ID único da coluna"),
 * @OA\Property(property="project_id", type="integer", description="ID do projeto ao qual a coluna pertence", example=1),
 * @OA\Property(property="name", type="string", description="Nome da coluna", example="A Fazer"),
 * @OA\Property(property="created_at", type="string", format="date-time", readOnly=true, description="Data de criação"),
 * @OA\Property(property="updated_at", type="string", format="date-time", readOnly=true, description="Data da última atualização")
 * )
 */
class Column extends Model
{
    use HasFactory;

    protected $fillable = [
        'project_id',
        'name',
    ];

    /**
     * Uma coluna pertence a um projeto.
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }

    /**
     * Uma coluna tem muitas tarefas.
     */
    public function tasks(): HasMany
    {
        return $this->hasMany(Task::class);
    }
}
