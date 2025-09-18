<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\TrackingService;
use App\Http\Requests\Tracking\StoreTrackingRequest;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Schema(
 * schema="StoreTrackingRequest",
 * required={"task_id", "user_id", "logged_at"},
 * @OA\Property(property="task_id", type="integer", example=1),
 * @OA\Property(property="user_id", type="integer", example=1),
 * @OA\Property(property="logged_at", type="string", format="date-time", example="2025-09-18 12:00:00")
 * )
 */
class TrackingController extends Controller
{
    protected $service;

    public function __construct(TrackingService $service)
    {
        $this->service = $service;
    }

    /**
     * @OA\Get(
     * path="/api/admin/trackings",
     * summary="Lista todos os registros de tracking",
     * tags={"Trackings"},
     * security={{"bearerAuth":{}}},
     * @OA\Response(response=200, description="Sucesso", @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Tracking")))
     * )
     */
    public function index(): JsonResponse
    {
        return response()->json($this->service->list(), 200);
    }

    /**
     * @OA\Get(
     * path="/api/admin/trackings/{id}",
     * summary="Busca um registro de tracking pelo ID",
     * tags={"Trackings"},
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\Response(response=200, description="Sucesso", @OA\JsonContent(ref="#/components/schemas/Tracking")),
     * @OA\Response(response=404, description="Registro não encontrado")
     * )
     */
    public function show($id): JsonResponse
    {
        $tracking = $this->service->find($id);
        return response()->json($tracking, 200);
    }

    /**
     * @OA\Post(
     * path="/api/admin/trackings",
     * summary="Cria um novo registro de tracking",
     * tags={"Trackings"},
     * security={{"bearerAuth":{}}},
     * @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/StoreTrackingRequest")),
     * @OA\Response(response=201, description="Criado com sucesso", @OA\JsonContent(ref="#/components/schemas/Tracking")),
     * @OA\Response(response=422, description="Erro de validação")
     * )
     */
    public function store(StoreTrackingRequest $request): JsonResponse
    {
        try {
            $tracking = $this->service->store($request->validated());
            return response()->json($tracking, 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao criar Tracking', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Put(
     * path="/api/admin/trackings/{id}",
     * summary="Atualiza um registro de tracking",
     * tags={"Trackings"},
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/StoreTrackingRequest")),
     * @OA\Response(response=200, description="Atualizado com sucesso", @OA\JsonContent(ref="#/components/schemas/Tracking")),
     * @OA\Response(response=404, description="Registro não encontrado")
     * )
     */
    public function update(StoreTrackingRequest $request, $id): JsonResponse
    {
        try {
            $tracking = $this->service->update($id, $request->validated());
            return response()->json($tracking, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao atualizar Tracking', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Delete(
     * path="/api/admin/trackings/{id}",
     * summary="Deleta um registro de tracking",
     * tags={"Trackings"},
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
            return response()->json(['message' => 'Tracking deletado com sucesso.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao deletar Tracking', 'error' => $e->getMessage()], 500);
        }
    }
}