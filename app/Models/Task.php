<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

/**
 * @OA\Schema(
 * schema="Task",
 * type="object",
 * title="Task",
 * properties={
 * @OA\Property(property="id", type="integer"),
 * @OA\Property(property="name", type="string", description="Nome da tarefa"),
 * @OA\Property(property="description", type="string", nullable=true, description="Descrição detalhada da tarefa"),
 * @OA\Property(property="due_date", type="string", format="date", description="Data de vencimento"),
 * @OA\Property(property="column", ref="#/components/schemas/Column", description="A coluna (status) à qual a tarefa pertence"),
 * @OA\Property(property="users", type="array", @OA\Items(ref="#/components/schemas/User"), description="Lista de usuários responsáveis pela tarefa"),
 * @OA\Property(property="involved_users", type="array", @OA\Items(type="integer"), description="Campo legado com IDs dos usuários envolvidos"),
 * @OA\Property(property="created_at", type="string", format="date-time"),
 * @OA\Property(property="updated_at", type="string", format="date-time")
 * }
 * )
 */
class Task extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'campaign_id',
        'user_id',
        'column_id',
        'name',
        'start_date',
        'type_task',
        'number',
        'description',
        'comment',
        'due_date',
        'priority',
        'file',
        'archived',
        'order_position',
        'involved_users',
        'timer_status',
        'last_started',
        'time_spent',
    ];

    protected $casts = [
        'start_date'     => 'date',
        'due_date'       => 'date',
        'archived'       => 'boolean',
        'involved_users' => 'array',
        'last_started'   => 'datetime',
        'time_spent'     => 'integer',
        'timer_status'   => 'integer',
    ];

    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function column(): BelongsTo 
    {
        return $this->belongsTo(Column::class);
    }

    public function history(): HasMany
    {
        return $this->hasMany(ColumnHistory::class);
    }

        public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'task_user');
    }
    
}