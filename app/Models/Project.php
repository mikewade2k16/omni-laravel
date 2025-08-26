<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
}
