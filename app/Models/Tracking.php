<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 * schema="Tracking",
 * type="object",
 * title="Tracking",
 * properties={
 * @OA\Property(property="id", type="integer"),
 * @OA\Property(property="task_id", type="integer", description="ID da tarefa associada"),
 * @OA\Property(property="user_id", type="integer", description="ID do usuário que realizou a ação"),
 * @OA\Property(property="logged_at", type="string", format="date-time", description="Data e hora do registro"),
 * @OA\Property(property="created_at", type="string", format="date-time"),
 * @OA\Property(property="updated_at", type="string", format="date-time")
 * }
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
