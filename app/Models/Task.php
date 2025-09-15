<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Task extends Model
{
    use HasFactory;

    // ATENÇÃO AQUI: 'status' foi removido e 'column_id' foi adicionado.
    protected $fillable = [
        'client_id',
        'campaign_id',
        'user_id',
        'column_id', // ADICIONADO
        'name',
        // 'status', // REMOVIDO
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

    /**
     * Relacionamento com Cliente.
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Relacionamento com Campaign.
     */
    public function campaign()
    {
        return $this->belongsTo(Campaign::class);
    }

    /**
     * Usuário responsável pela tarefa.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    /**
     * NOVO: Uma tarefa tem um histórico de mudanças de coluna.
     */
    public function history(): HasMany
    {
        return $this->hasMany(ColumnHistory::class);
    }
}