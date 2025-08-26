<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ShortLink extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'target_url',
        'short_url',
        'client_id',
        'hits',
    ];

    protected $casts = [
        'hits' => 'integer',
    ];

    /**
     * ShortLink pertence a um cliente (opcional).
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
