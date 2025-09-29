<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Task;

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