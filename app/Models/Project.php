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
 * description="Representa um projeto, que contém colunas, tarefas e membros.",
 * @OA\Property(property="id", type="integer", readOnly=true, description="ID único do projeto"),
 * @OA\Property(property="client_id", type="integer", description="ID do cliente associado ao projeto"),
 * @OA\Property(property="user_id", type="integer", description="ID do usuário que criou o projeto"),
 * @OA\Property(property="name", type="string", description="Nome do projeto", example="Lançamento Campanha de Verão"),
 * @OA\Property(property="description", type="string", nullable=true, description="Descrição detalhada do projeto"),
 * @OA\Property(property="status", type="string", description="Status atual do projeto", enum={"pending", "in_progress", "completed", "canceled"}, example="in_progress"),
 * @OA\Property(property="visibility", type="string", enum={"public", "private"}, description="Visibilidade do projeto", example="private"),
 * @OA\Property(property="type_project", type="string", nullable=true, description="Tipo ou natureza do projeto", example="Marketing Digital"),
 * @OA\Property(property="link", type="string", format="uri", nullable=true, description="Link externo relacionado ao projeto", example="http://miro.com/board/12345"),
 * @OA\Property(property="goal", type="string", nullable=true, description="O objetivo principal do projeto"),
 * @OA\Property(property="date_project", type="string", format="date", description="Data de início ou entrega do projeto", example="2025-12-31"),
 * @OA\Property(property="category", type="string", nullable=true, description="Categoria do projeto", example="E-commerce"),
 * @OA\Property(property="segment", type="string", nullable=true, description="Segmento de mercado do projeto", example="Moda"),
 * @OA\Property(property="created_at", type="string", format="date-time", readOnly=true, description="Data de criação"),
 * @OA\Property(property="updated_at", type="string", format="date-time", readOnly=true, description="Data da última atualização"),
 * @OA\Property(property="columns", type="array", readOnly=true, @OA\Items(ref="#/components/schemas/Column"), description="Lista de colunas do projeto"),
 * @OA\Property(property="members", type="array", readOnly=true, @OA\Items(ref="#/components/schemas/User"), description="Usuários que têm acesso ao projeto")
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