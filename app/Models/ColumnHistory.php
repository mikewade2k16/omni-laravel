<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ColumnHistory extends Model
{
    use HasFactory;

    // Nome da tabela precisa ser especificado se não seguir o padrão 'column_histories'
    protected $table = 'column_history';

    protected $fillable = [
        'task_id',
        'old_column_id',
        'new_column_id',
    ];

    /**
     * Um registro de histórico pertence a uma tarefa.
     */
    public function task(): BelongsTo
    {
        return $this->belongsTo(Task::class);
    }

    /**
     * Relacionamento com a coluna de origem.
     */
    public function oldColumn(): BelongsTo
    {
        return $this->belongsTo(Column::class, 'old_column_id');
    }

    /**
     * Relacionamento com a coluna de destino.
     */
    public function newColumn(): BelongsTo
    {
        return $this->belongsTo(Column::class, 'new_column_id');
    }
}