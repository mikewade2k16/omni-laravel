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
 * @OA\Property(property="id", type="integer", readOnly=true, description="ID único da associação"),
 * @OA\Property(property="user_id", type="integer", description="ID do usuário associado", example=1),
 * @OA\Property(property="project_id", type="integer", description="ID do projeto associado", example=1),
 * @OA\Property(property="created_at", type="string", format="date-time", readOnly=true, description="Data de criação da associação"),
 * @OA\Property(property="updated_at", type="string", format="date-time", readOnly=true, description="Data da última atualização da associação")
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
