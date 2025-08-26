<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Collection extends Model
{
    use HasFactory;


    protected $fillable = [
        'name',
        'slug',
        'client_id',
        'owner_id',
        'visibility',
        'agency_access',
        'icon',
        'description',
        'schema_json',
    ];

    protected $casts = [
        'agency_access' => 'boolean',
        'schema_json'   => 'array',
    ];

    /**
     * Relacionamento com o cliente (se houver).
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Relacionamento com o dono (usuário que criou).
     */
    public function owner()
    {
        return $this->belongsTo(User::class, 'owner_id');
    }
}
