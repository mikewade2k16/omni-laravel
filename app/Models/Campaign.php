<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Campaign extends Model
{
    use HasFactory;

    protected $fillable = [
        'client_id',
        'name',
        'description',
        'start_date',
        'end_date',
        'banner_image',
        'status',
        'channels',
    ];

    protected $casts = [
        'start_date' => 'date',
        'end_date'   => 'date',
        'channels'   => 'array',
    ];

    /**
     * Uma campanha pertence a um cliente.
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }
}
