<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Qrcode extends Model
{
    use HasFactory;

    protected $fillable = [
        'slug',
        'target_url',
        'scan_count',
        'last_scanned_at',
        'qr_image_path',
        'is_active',
        'client_id',
        'created_by',
    ];

    protected $casts = [
        'scan_count'      => 'integer',
        'last_scanned_at' => 'datetime',
        'is_active'       => 'boolean',
    ];

    /**
     * QRCode pertence a um cliente (opcional).
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Usuário que criou o QRCode.
     */
    public function creator()
    {
        return $this->belongsTo(User::class, 'created_by');
    }
}
