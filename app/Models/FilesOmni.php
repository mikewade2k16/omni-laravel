<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use App\Enums\FilesOmniVersionEnum;
use App\Enums\FilesOmniVideoOrientationEnum;

/**
 * @OA\Schema(
 * schema="FilesOmni",
 * type="object",
 * title="Files Omni",
 * description="Representa um arquivo genérico no sistema, associado a um cliente e opcionalmente a uma tarefa.",
 * @OA\Property(property="id", type="integer", readOnly=true, description="ID único do arquivo"),
 * @OA\Property(property="task_id", type="integer", nullable=true, description="ID da tarefa associada (opcional)"),
 * @OA\Property(property="client_id", type="integer", description="ID do cliente associado"),
 * @OA\Property(property="uploaded_by", type="integer", description="ID do usuário que fez o upload"),
 * @OA\Property(property="file_path", type="string", description="Caminho do arquivo no storage", example="clients/1/tasks/123/video.mp4"),
 * @OA\Property(property="file_name", type="string", description="Nome original do arquivo", example="video_casamento.mp4"),
 * @OA\Property(property="file_type", type="string", description="MIME type do arquivo", example="video/mp4"),
 * @OA\Property(property="version", type="string", description="Versão do arquivo (ex: original, editado)", enum={"original", "editado", "preview"}, example="original"),
 * @OA\Property(property="cover_image", type="string", nullable=true, description="Caminho para a imagem de capa do arquivo (geralmente para vídeos)", example="clients/1/tasks/123/cover.jpg"),
 * @OA\Property(property="video_orientation", type="string", nullable=true, description="Orientação do vídeo", enum={"landscape", "portrait"}, example="landscape"),
 * @OA\Property(property="published", type="boolean", description="Indica se o arquivo está publicado e visível para o cliente", example=true),
 * @OA\Property(property="created_at", type="string", format="date-time", readOnly=true, description="Data de criação"),
 * @OA\Property(property="updated_at", type="string", format="date-time", readOnly=true, description="Data da última atualização")
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
        'version' => FilesOmniVersionEnum::class,
        'video_orientation' => FilesOmniVideoOrientationEnum::class,
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
