<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Project extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'name',
        'status',
        'type_project',
        'link',
        'goal',
        'description',
        'date_project',
        'category',
        'segment',
    ];

    protected $casts = [
        'date_project' => 'date',
    ];

    /**
     * Um projeto pertence a um cliente.
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * NOVO: Um projeto tem muitas colunas.
     */
    public function columns(): HasMany
    {
        return $this->hasMany(Column::class);
    }

    /**
     * NOVO: Um projeto tem muitas tarefas através das colunas.
     */
    public function tasks(): HasManyThrough
    {
        return $this->hasManyThrough(Task::class, Column::class);
    }
}