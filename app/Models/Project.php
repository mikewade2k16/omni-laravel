<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
/**
 * @OA\Schema(
 * schema="Project",
 * type="object",
 * title="Project",
 * properties={
 * @OA\Property(property="id", type="integer"),
 * @OA\Property(property="client_id", type="integer"),
 * @OA\Property(property="name", type="string"),
 * @OA\Property(property="status", type="string", example="in_progress"),
 * @OA\Property(property="description", type="string"),
 * @OA\Property(property="date_project", type="string", format="date", example="2025-12-31"),
 * @OA\Property(property="created_at", type="string", format="date-time"),
 * @OA\Property(property="updated_at", type="string", format="date-time"),
 * @OA\Property(property="columns", type="array", @OA\Items(ref="#/components/schemas/Column")),
 * }
 * )
 */
class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'name',
        'status',
        'type_project',
        'link',
        'goal',
        'description',
        'date_project',
        'category',
        'segment',
    ];

    protected $casts = [
        'date_project' => 'date',
    ];

    /**
     * Um projeto pertence a um cliente.
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * NOVO: Um projeto tem muitas colunas.
     */
    public function columns(): HasMany
    {
        return $this->hasMany(Column::class);
    }

    /**
     * NOVO: Um projeto tem muitas tarefas através das colunas.
     */
    public function tasks(): HasManyThrough
    {
        return $this->hasManyThrough(Task::class, Column::class);
    }
}