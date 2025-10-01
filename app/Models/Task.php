<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use App\Enums\TaskTypeEnum;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Activitylog\LogOptions;

/**
 * @OA\Schema(
 * schema="Task",
 * type="object",
 * title="Task",
 * description="Representa uma tarefa dentro de um projeto ou campanha.",
 * @OA\Property(property="id", type="integer", readOnly=true, description="ID único da tarefa"),
 * @OA\Property(property="client_id", type="integer", nullable=true, description="ID do cliente associado à tarefa"),
 * @OA\Property(property="campaign_id", type="integer", nullable=true, description="ID da campanha associada à tarefa"),
 * @OA\Property(property="user_id", type="integer", description="ID do usuário que criou a tarefa (Esse usuário é automaticamente adicionado como envolvido)"),
 * @OA\Property(property="column_id", type="integer", description="ID da coluna (status) à qual a tarefa pertence"),
 * @OA\Property(property="name", type="string", description="Nome ou título da tarefa", example="Criar layout para post de Instagram"),
 * @OA\Property(property="start_date", type="string", format="date", nullable=true, description="Data de início da tarefa"),
 * @OA\Property(property="type_task", type="string", enum={"bug", "feature", "improvement", "epic"}, description="Tipo da tarefa", example="feature"),
 * @OA\Property(property="number", type="integer", nullable=true, description="Número identificador da tarefa (se aplicável)"),
 * @OA\Property(property="description", type="string", nullable=true, description="Descrição detalhada da tarefa"),
 * @OA\Property(property="comment", type="string", nullable=true, description="Comentários adicionais sobre a tarefa"),
 * @OA\Property(property="due_date", type="string", format="date", nullable=true, description="Data de vencimento da tarefa"),
 * @OA\Property(property="priority", type="string", enum={"low", "medium", "high", "urgent"}, description="Nível de prioridade da tarefa", example="high"),
 * @OA\Property(property="file", type="string", nullable=true, description="Caminho para um arquivo anexo à tarefa"),
 * @OA\Property(property="archived", type="boolean", description="Indica se a tarefa está arquivada", default=false),
 * @OA\Property(property="order_position", type="integer", description="Posição ordinal da tarefa dentro da sua coluna para ordenação", example=1),
 * @OA\Property(property="involved_users", type="array", @OA\Items(type="integer"), description="Array com os IDs dos usuários envolvidos/responsáveis pela tarefa", example={1, 5}),
 * @OA\Property(property="timer_status", type="integer", description="Status do cronômetro (ex: 0=parado, 1=rodando)", example=0),
 * @OA\Property(property="last_started", type="string", format="date-time", nullable=true, description="Última vez que o cronômetro da tarefa foi iniciado"),
 * @OA\Property(property="time_spent", type="integer", description="Tempo total gasto na tarefa (em segundos)", example=3600),
 * @OA\Property(property="created_at", type="string", format="date-time", readOnly=true, description="Data de criação"),
 * @OA\Property(property="updated_at", type="string", format="date-time", readOnly=true, description="Data da última atualização")
 * )
 */
class Task extends Model
{
    use HasFactory, LogsActivity;

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
        'type_task'      => TaskTypeEnum::class,
    ];
    /**
     * O método "boot" do model.
     *
     * @return void
     */
    protected static function boot()
    {
        parent::boot();

        static::created(function ($task) {
            $task->users()->attach($task->user_id, [], false);
        });
    }
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            // Loga todos os atributos que estão no seu array $fillable
            ->logFillable()

            // Só cria um log se algum campo realmente mudou
            ->logOnlyDirty()

            // Descreve o que aconteceu no log
            ->setDescriptionForEvent(fn(string $eventName) => "Tarefa {$eventName}")

            // Não salva logs de "update" onde nada mudou
            ->dontSubmitEmptyLogs();
    }
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