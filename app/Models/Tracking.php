<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
