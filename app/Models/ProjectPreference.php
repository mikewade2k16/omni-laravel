<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ProjectPreference extends Model
{
    use HasFactory;

    protected $table = 'project_preferences';

    protected $fillable = [
        'user_id',
        'project_id',
        'settings',
    ];

    /**
     * Converte a coluna 'settings' de JSON para array automaticamente.
     */
    protected $casts = [
        'settings' => 'array',
    ];

    /**
     * Relacionamento: a preferência pertence a um usuário.
     */
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relacionamento: a preferência pertence a um projeto.
     */
    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}