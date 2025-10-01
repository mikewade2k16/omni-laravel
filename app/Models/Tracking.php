<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 * schema="Tracking",
 * type="object",
 * title="Tracking",
 * description="Registra um evento ou ponto de controle de tempo para uma tarefa específica.",
 * @OA\Property(property="id", type="integer", readOnly=true, description="ID único do registro de tracking"),
 * @OA\Property(property="task_id", type="integer", description="ID da tarefa que está sendo rastreada", example=101),
 * @OA\Property(property="user_id", type="integer", description="ID do usuário que acionou o registro de tracking", example=5),
 * @OA\Property(property="logged_at", type="string", format="date-time", description="Data e hora em que o evento foi registrado"),
 * @OA\Property(property="created_at", type="string", format="date-time", readOnly=true, description="Data de criação do registro"),
 * @OA\Property(property="updated_at", type="string", format="date-time", readOnly=true, description="Data da última atualização do registro")
 * )
 */
class Tracking extends Model
{
    use HasFactory;

    protected $fillable = [
        'task_id',
        'user_id',
        'logged_at',
    ];

    protected $casts = [
        'logged_at' => 'datetime',
    ];

    /**
     * Relacionamento com Task.
     */
    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    /**
     * Usuário que realizou a ação.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
