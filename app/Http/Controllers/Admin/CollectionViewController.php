<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\CollectionView\StoreCollectionViewRequest;
use App\Http\Requests\CollectionView\UpdateCollectionViewRequest;
use App\Http\Resources\CollectionViewResource;
use App\Services\CollectionViewService;
use App\Models\CollectionView;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Schema(
 * schema="StoreCollectionViewRequest",
 * required={"collection_id", "name", "type"},
 * @OA\Property(property="collection_id", type="integer", example=1),
 * @OA\Property(property="name", type="string", example="Visualização em Tabela"),
 * @OA\Property(property="type", type="string", example="table"),
 * @OA\Property(
 * property="config",
 * type="object",
 * example={"columns": {"email", "telefone", "status_lead"}}
 * )
 * )
 *
 * @OA\Schema(
 * schema="UpdateCollectionViewRequest",
 * @OA\Property(property="name", type="string", example="Visualização Kanban de Leads")
 * )
 */
class CollectionViewController extends Controller
{
    protected $service;

    public function __construct(CollectionViewService $service)
    {
        $this->service = $service;
    }

    /**
     * @OA\Get(
     * path="/api/admin/collection-views",
     * summary="Lista todas as visualizações de coleção",
     * tags={"Collection Views"},
     * security={{"bearerAuth":{}}},
     * @OA\Response(response=200, description="Sucesso", @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/CollectionView")))
     * )
     */
    public function index()
    {
        $views = $this->service->list();
        return CollectionViewResource::collection($views);
    }

    /**
     * @OA\Get(
     * path="/api/admin/collection-views/{id}",
     * summary="Busca uma visualização pelo ID",
     * tags={"Collection Views"},
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\Response(response=200, description="Sucesso", @OA\JsonContent(ref="#/components/schemas/CollectionView")),
     * @OA\Response(response=404, description="Visualização não encontrada")
     * )
     */
    public function show($id): JsonResponse
    {
        try {
            $view = $this->service->find($id);

            if (!$view) {
                return response()->json(['message' => 'CollectionView não encontrada'], 404);
            }
            return response()->json(new CollectionViewResource($view), 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao buscar CollectionView', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Post(
     * path="/api/admin/collection-views",
     * summary="Cria uma nova visualização de coleção",
     * tags={"Collection Views"},
     * security={{"bearerAuth":{}}},
     * @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/StoreCollectionViewRequest")),
     * @OA\Response(response=201, description="Criado com sucesso", @OA\JsonContent(ref="#/components/schemas/CollectionView")),
     * @OA\Response(response=422, description="Erro de validação")
     * )
     */
    public function store(StoreCollectionViewRequest $request): JsonResponse
    {
        try {
            $view = $this->service->store($request->validated()); // Padronizado de create para store
            return response()->json(new CollectionViewResource($view), 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao criar CollectionView',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Put(
     * path="/api/admin/collection-views/{id}",
     * summary="Atualiza uma visualização de coleção",
     * tags={"Collection Views"},
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/UpdateCollectionViewRequest")),
     * @OA\Response(response=200, description="Atualizado com sucesso", @OA\JsonContent(ref="#/components/schemas/CollectionView")),
     * @OA\Response(response=404, description="Visualização não encontrada")
     * )
     */
    public function update(UpdateCollectionViewRequest $request, $id): JsonResponse
    {
        try {
            $view = $this->service->update($id, $request->validated());
            return response()->json(new CollectionViewResource($view), 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao atualizar CollectionView',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Delete(
     * path="/api/admin/collection-views/{id}",
     * summary="Deleta uma visualização de coleção",
     * tags={"Collection Views"},
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\Response(response=200, description="Deletado com sucesso"),
     * @OA\Response(response=404, description="Visualização não encontrada")
     * )
     */
    public function destroy($id): JsonResponse
    {
        try {
            $this->service->delete($id);
            return response()->json(['message' => 'CollectionView deletado com sucesso.']);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao deletar CollectionView',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}