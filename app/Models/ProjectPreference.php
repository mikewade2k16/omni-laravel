<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @OA\Schema(
 * schema="ProjectPreference",
 * type="object",
 * title="Project Preference",
 * description="Preferências de um usuário para um projeto específico",
 * properties={
 * @OA\Property(property="id", type="integer"),
 * @OA\Property(property="user_id", type="integer"),
 * @OA\Property(property="project_id", type="integer"),
 * @OA\Property(
 * property="settings",
 * type="object",
 * @OA\Property(property="view_type", type="string", enum={"card", "list"})
 * ),
 * @OA\Property(property="created_at", type="string", format="date-time"),
 * @OA\Property(property="updated_at", type="string", format="date-time")
 * }
 * )
 */
class ProjectPreference extends Model
{
    use HasFactory;

    protected $table = 'project_preferences';

    protected $fillable = [
        'user_id',
        'project_id',
        'settings',
    ];

    protected $casts = [
        'settings' => 'array',
    ];


    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function project(): BelongsTo
    {
        return $this->belongsTo(Project::class);
    }
}