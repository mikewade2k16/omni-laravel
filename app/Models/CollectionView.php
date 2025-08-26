<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class CollectionView extends Model
{
    use HasFactory;

    protected $fillable = [
        'collection_id',
        'name',
        'type',
        'config',
        'created_by',
    ];

    protected $casts = [
        'config' => 'array', // converte JSON armazenado em array automaticamente
    ];

    /**
     * View pertence a uma coleção.
     */
    public function collection()
    {
        return $this->belongsTo(Collection::class);
    }

    /**
     * Usuário que criou a view.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
