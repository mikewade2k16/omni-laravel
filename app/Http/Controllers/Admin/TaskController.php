<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Task\StoreTaskRequest;
use App\Http\Requests\Task\UpdateTaskRequest;
use App\Http\Resources\TaskResource;
use App\Services\TaskService;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Schema(
 * schema="StoreTaskRequest",
 * type="object",
 * title="Store Task Request",
 * required={"client_id", "user_id", "name", "column_id", "type_task", "priority"},
 * properties={
 * @OA\Property(property="client_id", type="integer", example=1),
 * @OA\Property(property="campaign_id", type="integer", example=1, nullable=true),
 * @OA\Property(property="user_id", type="integer", example=1, description="ID do usuário 'dono' da tarefa"),
 * @OA\Property(property="name", type="string", example="Desenvolver API de Pagamentos"),
 * @OA\Property(property="column_id", type="integer", example=1),
 * @OA\Property(property="type_task", type="string", description="Tipo da tarefa", enum={"design", "video", "filme", "copy", "3D", "site", "planejamento", "CRM", "tráfego pago"}),
 * @OA\Property(property="number", type="integer", example=101, nullable=true),
 * @OA\Property(property="description", type="string", example="Integrar com a API do gateway X.", nullable=true),
 * @OA\Property(property="start_date", type="string", format="date", example="2025-10-01", nullable=true),
 * @OA\Property(property="due_date", type="string", format="date", example="2025-10-15", nullable=true),
 * @OA\Property(property="priority", type="integer", description="Prioridade da tarefa", example=1),
 * @OA\Property(property="involved_users", type="array", @OA\Items(type="integer"), example={1, 2}, nullable=true)
 * }
 * )
 *
 * @OA\Schema(
 * schema="UpdateTaskRequest",
 * @OA\Property(property="name", type="string", example="[CONCLUÍDO] Desenvolver API de Pagamentos"),
 * @OA\Property(property="column_id", type="integer", example=3),
 * @OA\Property(property="involved_users", type="array", @OA\Items(type="integer"), example={1})
 * )
 */
class TaskController extends Controller
{
    protected $service;

    public function __construct(TaskService $service)
    {
        $this->service = $service;
    }

    /**
     * @OA\Get(
     * path="/api/admin/tasks",
     * summary="Lista todas as tarefas",
     * tags={"Tasks"},
     * security={{"bearerAuth":{}}},
     * @OA\Response(response=200, description="Sucesso", @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Task")))
     * )
     */
    public function index()
    {
        return TaskResource::collection($this->service->list());
    }

    /**
     * @OA\Get(
     * path="/api/admin/tasks/{id}",
     * summary="Busca uma tarefa pelo ID",
     * tags={"Tasks"},
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\Response(response=200, description="Sucesso", @OA\JsonContent(ref="#/components/schemas/Task")),
     * @OA\Response(response=404, description="Tarefa não encontrada")
     * )
     */
    public function show($id): JsonResponse
    {
        try {
            $task = $this->service->find($id);

            if (!$task) {
                return response()->json(['message' => 'Tarefa não encontrada'], 404);
            }
            return response()->json(new TaskResource($task), 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao buscar tarefa', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Post(
     * path="/api/admin/tasks",
     * summary="Cria uma nova tarefa",
     * tags={"Tasks"},
     * security={{"bearerAuth":{}}},
     * @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/StoreTaskRequest")),
     * @OA\Response(response=201, description="Criado com sucesso", @OA\JsonContent(ref="#/components/schemas/Task")),
     * @OA\Response(response=422, description="Erro de validação")
     * )
     */
    public function store(StoreTaskRequest $request): JsonResponse
    {
        try {
            $task = $this->service->store($request->validated());
            return response()->json(new TaskResource($task), 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao criar Tarefa',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Put(
     * path="/api/admin/tasks/{id}",
     * summary="Atualiza uma tarefa",
     * tags={"Tasks"},
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/UpdateTaskRequest")),
     * @OA\Response(response=200, description="Atualizado com sucesso", @OA\JsonContent(ref="#/components/schemas/Task")),
     * @OA\Response(response=404, description="Tarefa não encontrada")
     * )
     */
    public function update(UpdateTaskRequest $request, $id): JsonResponse
    {
        try {
            $task = $this->service->update($id, $request->validated());
            return response()->json(new TaskResource($task), 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao atualizar Tarefa',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Delete(
     * path="/api/admin/tasks/{id}",
     * summary="Deleta uma tarefa",
     * tags={"Tasks"},
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\Response(response=200, description="Deletado com sucesso"),
     * @OA\Response(response=404, description="Tarefa não encontrada")
     * )
     */
    public function destroy($id): JsonResponse
    {
        try {
            $this->service->delete($id);
            return response()->json(['message' => 'Tarefa deletada com sucesso.']);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao deletar Tarefa',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}