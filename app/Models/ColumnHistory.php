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
 * properties={
 * @OA\Property(property="id", type="integer"),
 * @OA\Property(property="task_id", type="integer"),
 * @OA\Property(property="old_column", ref="#/components/schemas/Column", description="A coluna de onde a tarefa saiu"),
 * @OA\Property(property="new_column", ref="#/components/schemas/Column", description="A coluna para onde a tarefa foi"),
 * @OA\Property(property="changed_at", type="string", format="date-time", description="Quando a mudança ocorreu"),
 * }
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