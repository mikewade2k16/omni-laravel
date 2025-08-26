<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

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
