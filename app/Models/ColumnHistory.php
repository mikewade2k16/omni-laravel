<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @OA\Schema(
 * schema="ColumnHistory",
 * type="object",
 * title="Column History",
 * description="Registra o histórico de movimentação de uma tarefa entre colunas.",
 * @OA\Property(property="id", type="integer", readOnly=true, description="ID único do registro de histórico"),
 * @OA\Property(property="task_id", type="integer", description="ID da tarefa que foi movida"),
 * @OA\Property(property="old_column_id", type="integer", description="ID da coluna de origem da tarefa"),
 * @OA\Property(property="new_column_id", type="integer", description="ID da coluna de destino da tarefa"),
 * @OA\Property(property="created_at", type="string", format="date-time", readOnly=true, description="Data em que a mudança ocorreu"),
 * @OA\Property(property="updated_at", type="string", format="date-time", readOnly=true, description="Data da última atualização do registro")
 * )
 */
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