<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 * schema="Qrcode",
 * type="object",
 * title="QR Code",
 * properties={
 * @OA\Property(property="id", type="integer"),
 * @OA\Property(property="slug", type="string", description="Identificador único para a URL do QR Code"),
 * @OA\Property(property="target_url", type="string", format="url", description="A URL de destino para onde o QR Code aponta"),
 * @OA\Property(property="scan_count", type="integer", description="Número de vezes que o QR Code foi escaneado"),
 * @OA\Property(property="last_scanned_at", type="string", format="date-time", nullable=true, description="Data e hora do último escaneamento"),
 * @OA\Property(property="qr_image_path", type="string", description="Caminho para a imagem gerada do QR Code"),
 * @OA\Property(property="is_active", type="boolean", description="Indica se o QR Code está ativo"),
 * @OA\Property(property="client_id", type="integer", nullable=true, description="ID do cliente associado"),
 * @OA\Property(property="created_by", type="integer", description="ID do usuário que criou o QR Code"),
 * @OA\Property(property="created_at", type="string", format="date-time"),
 * @OA\Property(property="updated_at", type="string", format="date-time")
 * }
 * )
 */
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
