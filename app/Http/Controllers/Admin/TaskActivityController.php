<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Task;

/**
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
class TaskActivityController extends Controller
{
    /**
     * @OA\Get(
     * path="/api/admin/tasks/{task}/activities",
     * summary="Lista o histórico de atividades de uma tarefa",
     * tags={"Tasks"},
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(
     * name="task",
     * in="path",
     * required=true,
     * description="ID da tarefa",
     * @OA\Schema(type="integer")
     * ),
     * @OA\Response(
     * response=200,
     * description="Operação bem-sucedida",
     * @OA\JsonContent(
     * type="array",
     * @OA\Items(ref="#/components/schemas/ActivityLog")
     * )
     * ),
     * @OA\Response(response=404, description="Tarefa não encontrada")
     * )
     */
    public function index(Task $task)
    {
        return response()->json($task->activities);
    }
}