<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

/**
 * @OA\Schema(
 * schema="ProjectUser",
 * type="object",
 * title="User Project Association",
 * description="Modelo que representa a ligação entre um usuário e um projeto",
 * properties={
 * @OA\Property(property="id", type="integer"),
 * @OA\Property(property="user_id", type="integer", description="ID do usuário"),
 * @OA\Property(property="project_id", type="integer", description="ID do projeto"),
 * @OA\Property(property="created_at", type="string", format="date-time"),
 * @OA\Property(property="updated_at", type="string", format="date-time")
 * }
 * )
 */
class ProjectUser extends Model
{
    use HasFactory;

    protected $table = 'project_user';

    protected $fillable = [
        'user_id',
        'project_id',
    ];
}
