<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Enums\ProjectStatusEnum;

/**
 * @OA\Schema(
 * schema="Project",
 * type="object",
 * title="Project",
 * properties={
 * @OA\Property(property="id", type="integer"),
 * @OA\Property(property="user_id", type="integer", description="ID do usuário que criou o projeto"),
 * @OA\Property(property="client_id", type="integer"),
 * @OA\Property(property="name", type="string"),
 * @OA\Property(property="visibility", type="string", enum={"public", "private"}, description="Visibilidade do projeto"),
 * @OA\Property(property="status", type="string", example="in_progress"),
 * @OA\Property(property="description", type="string"),
 * @OA\Property(property="date_project", type="string", format="date", example="2025-12-31"),
 * @OA\Property(property="created_at", type="string", format="date-time"),
 * @OA\Property(property="updated_at", type="string", format="date-time"),
 * @OA\Property(property="columns", type="array", @OA\Items(ref="#/components/schemas/Column")),
 * @OA\Property(property="members", type="array", @OA\Items(ref="#/components/schemas/User"), description="Usuários que têm acesso ao projeto")
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
        'user_id',     
        'visibility',  
    ];

    protected $casts = [
        'date_project' => 'date',
        'status' => ProjectStatusEnum::class,
    ];

    /**
     * Um projeto pertence a um cliente.
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Um projeto tem muitas colunas.
     */
    public function columns(): HasMany
    {
        return $this->hasMany(Column::class);
    }

    /**
     * Um projeto tem muitas tarefas através das colunas.
     */
    public function tasks(): HasManyThrough
    {
        return $this->hasManyThrough(Task::class, Column::class);
    }

    /**
     * O usuário que criou o projeto.
     */
    public function creator(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    /**
     * Os usuários que têm acesso a este projeto.
     */
    public function members(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'project_user');
    }
}