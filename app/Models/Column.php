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
 * properties={
 * @OA\Property(property="id", type="integer"),
 * @OA\Property(property="project_id", type="integer"),
 * @OA\Property(property="name", type="string"),
 * @OA\Property(property="created_at", type="string", format="date-time"),
 * @OA\Property(property="updated_at", type="string", format="date-time")
 * }
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