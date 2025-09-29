<?php
namespace App\Http\Controllers;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
/**
 * @OA\Info(
 * version="1.0.0",
 * title="Omni - Documentação da API",
 * description="Documentação de todos os endpoints da API do sistema Omni."
 * )
 * @OA\SecurityScheme(
 * type="http",
 * scheme="bearer",
 * bearerFormat="JWT",
 * securityScheme="bearerAuth"
 * )
 *
 * @OA\Schema(
 * schema="ActivityLog",
 * type="object",
 * title="Activity Log Record",
 * description="Registro de uma atividade (log) realizada em um modelo",
 * properties={
 * @OA\Property(property="id", type="integer"),
 * @OA\Property(property="log_name", type="string", example="Task"),
 * @OA\Property(property="description", type="string", example="updated"),
 * @OA\Property(property="subject_type", type="string", example="App\Models\Task"),
 * @OA\Property(property="subject_id", type="integer", example=1),
 * @OA\Property(property="causer_id", type="integer", example=1, description="ID do usuário que causou a ação"),
 * @OA\Property(property="properties", type="object", description="JSON com os dados antigos e novos"),
 * @OA\Property(property="created_at", type="string", format="date-time")
 * }
 * )
 */
class Controller extends BaseController
{
    use AuthorizesRequests, ValidatesRequests;
}