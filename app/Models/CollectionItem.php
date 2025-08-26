<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CollectionItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'collection_id',
        'data',
        'created_by',
        'updated_by',
    ];

    protected $casts = [
        'data' => 'array', // armazena JSON como array
    ];

    /**
     * Item pertence a uma coleção.
     */
    public function collection()
    {
        return $this->belongsTo(Collection::class);
    }

    /**
     * Usuário que criou o item.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }

    /**
     * Usuário que atualizou o item.
     */
    public function updater()
    {
        return $this->belongsTo(User::class, 'updated_by');
    }
}
