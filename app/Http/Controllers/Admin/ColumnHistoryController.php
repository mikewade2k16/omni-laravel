<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\ColumnHistory\StoreColumnHistoryRequest;
use App\Http\Requests\ColumnHistory\UpdateColumnHistoryRequest;
use App\Http\Resources\ColumnHistoryResource;
use App\Services\ColumnHistoryService;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Schema(
 * schema="StoreColumnHistoryRequest",
 * required={"task_id", "new_column_id"},
 * @OA\Property(property="task_id", type="integer", example=1),
 * @OA\Property(property="old_column_id", type="integer", example=1, nullable=true, description="ID da coluna antiga"),
 * @OA\Property(property="new_column_id", type="integer", example=2, description="ID da nova coluna")
 * )
 *
 * @OA\Schema(
 * schema="UpdateColumnHistoryRequest",
 * @OA\Property(property="new_column_id", type="integer", example=3)
 * )
 */
class ColumnHistoryController extends Controller
{
    protected $service;

    public function __construct(ColumnHistoryService $service)
    {
        $this->service = $service;
    }

    /**
     * @OA\Get(
     * path="/api/admin/column-histories",
     * summary="Lista todos os históricos de mudança de coluna",
     * tags={"Column Histories"},
     * security={{"bearerAuth":{}}},
     * @OA\Response(response=200, description="Sucesso", @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/ColumnHistory")))
     * )
     */
    public function index()
    {
        $histories = $this->service->list();
        return ColumnHistoryResource::collection($histories);
    }

    /**
     * @OA\Get(
     * path="/api/admin/column-histories/{id}",
     * summary="Busca um registro de histórico pelo ID",
     * tags={"Column Histories"},
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\Response(response=200, description="Sucesso", @OA\JsonContent(ref="#/components/schemas/ColumnHistory")),
     * @OA\Response(response=404, description="Registro não encontrado")
     * )
     */
    public function show($id): JsonResponse
    {
        try {
            $history = $this->service->find($id);

            if (!$history) {
                return response()->json(['message' => 'Histórico não encontrado'], 404);
            }
            return response()->json(new ColumnHistoryResource($history), 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao buscar histórico', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Post(
     * path="/api/admin/column-histories",
     * summary="Cria um novo registro de histórico",
     * tags={"Column Histories"},
     * security={{"bearerAuth":{}}},
     * @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/StoreColumnHistoryRequest")),
     * @OA\Response(response=201, description="Criado com sucesso", @OA\JsonContent(ref="#/components/schemas/ColumnHistory")),
     * @OA\Response(response=422, description="Erro de validação")
     * )
     */
    public function store(StoreColumnHistoryRequest $request): JsonResponse
    {
        try {
            $history = $this->service->store($request->validated());
            return response()->json(new ColumnHistoryResource($history), 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao criar Histórico',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Put(
     * path="/api/admin/column-histories/{id}",
     * summary="Atualiza um registro de histórico",
     * tags={"Column Histories"},
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/UpdateColumnHistoryRequest")),
     * @OA\Response(response=200, description="Atualizado com sucesso", @OA\JsonContent(ref="#/components/schemas/ColumnHistory")),
     * @OA\Response(response=404, description="Registro não encontrado")
     * )
     */
    public function update(UpdateColumnHistoryRequest $request, $id): JsonResponse
    {
        try {
            $history = $this->service->update($id, $request->validated());
            return response()->json(new ColumnHistoryResource($history), 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao atualizar Histórico',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Delete(
     * path="/api/admin/column-histories/{id}",
     * summary="Deleta um registro de histórico",
     * tags={"Column Histories"},
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\Response(response=200, description="Deletado com sucesso"),
     * @OA\Response(response=404, description="Registro não encontrado")
     * )
     */
    public function destroy($id): JsonResponse
    {
        try {
            $this->service->delete($id);
            return response()->json(['message' => 'Histórico deletado com sucesso.']);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao deletar Histórico',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}