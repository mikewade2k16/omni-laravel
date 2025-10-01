<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 * schema="Qrcode",
 * type="object",
 * title="QR Code",
 * description="Representa um QR Code dinâmico que pode ser rastreado.",
 * @OA\Property(property="id", type="integer", readOnly=true, description="ID único do QR Code"),
 * @OA\Property(property="slug", type="string", description="Identificador único para a URL de acesso do QR Code", example="campanha-verao-2025"),
 * @OA\Property(property="target_url", type="string", format="url", description="A URL de destino para onde o QR Code redireciona", example="https://minhaempresa.com/promocao"),
 * @OA\Property(property="scan_count", type="integer", description="Número de vezes que o QR Code foi escaneado", example=150),
 * @OA\Property(property="last_scanned_at", type="string", format="date-time", nullable=true, description="Data e hora do último escaneamento"),
 * @OA\Property(property="qr_image_path", type="string", description="Caminho para a imagem gerada do QR Code no storage", example="qrcodes/campanha-verao-2025.svg"),
 * @OA\Property(property="is_active", type="boolean", description="Indica se o QR Code está ativo e pode ser escaneado", example=true),
 * @OA\Property(property="client_id", type="integer", nullable=true, description="ID do cliente associado a este QR Code (opcional)"),
 * @OA\Property(property="created_by", type="integer", description="ID do usuário que criou o QR Code"),
 * @OA\Property(property="created_at", type="string", format="date-time", readOnly=true, description="Data de criação"),
 * @OA\Property(property="updated_at", type="string", format="date-time", readOnly=true, description="Data da última atualização")
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
