<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 * schema="FilesOmni",
 * type="object",
 * title="Files Omni",
 * properties={
 * @OA\Property(property="id", type="integer"),
 * @OA\Property(property="task_id", type="integer", nullable=true, description="ID da tarefa associada"),
 * @OA\Property(property="client_id", type="integer", description="ID do cliente associado"),
 * @OA\Property(property="uploaded_by", type="integer", description="ID do usuário que fez o upload"),
 * @OA\Property(property="file_path", type="string", description="Caminho do arquivo no storage"),
 * @OA\Property(property="file_name", type="string", description="Nome original do arquivo"),
 * @OA\Property(property="file_type", type="string", description="MIME type do arquivo (ex: 'image/jpeg')"),
 * @OA\Property(property="version", type="integer", description="Versão do arquivo"),
 * @OA\Property(property="published", type="boolean", description="Se o arquivo está publicado ou não"),
 * @OA\Property(property="created_at", type="string", format="date-time"),
 * @OA\Property(property="updated_at", type="string", format="date-time")
 * }
 * )
 */
class FilesOmni extends Model
{
    use HasFactory;

    protected $table = 'files_omnis';

    protected $fillable = [
        'task_id',
        'client_id',
        'uploaded_by',
        'file_path',
        'file_name',
        'file_type',
        'version',
        'cover_image',
        'video_orientation',
        'published',
    ];

    protected $casts = [
        'published' => 'boolean',
    ];

    /**
     * Relacionamento com Task (se existir).
     */
    public function task()
    {
        return $this->belongsTo(Task::class);
    }

    /**
     * Relacionamento com Client.
     */
    public function client()
    {
        return $this->belongsTo(Client::class);
    }

    /**
     * Usuário que fez o upload.
     */
    public function uploader()
    {
        return $this->belongsTo(User::class, 'uploaded_by');
    }
}
