<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\CollectionItemService;
use App\Http\Requests\CollectionItem\StoreCollectionItemRequest;
use App\Http\Requests\CollectionItem\UpdateCollectionItemRequest;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Schema(
 * schema="StoreCollectionItemRequest",
 * required={"collection_id", "data"},
 * @OA\Property(property="collection_id", type="integer", example=1),
 * @OA\Property(property="data", type="object", example={"email": "cliente@example.com", "telefone": "79999999999"})
 * )
 *
 * @OA\Schema(
 * schema="UpdateCollectionItemRequest",
 * @OA\Property(property="data", type="object", example={"email": "novocliente@example.com", "status_lead": "convertido"})
 * )
 */
class CollectionItemController extends Controller
{
    protected $service;

    public function __construct(CollectionItemService $service)
    {
        $this->service = $service;
    }

    /**
     * @OA\Get(
     * path="/api/admin/collection-items",
     * summary="Lista todos os itens de coleções",
     * tags={"Collection Items"},
     * security={{"bearerAuth":{}}},
     * @OA\Response(response=200, description="Sucesso", @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/CollectionItem")))
     * )
     */
    public function index()
    {
        return $this->service->list();
    }

    /**
     * @OA\Get(
     * path="/api/admin/collection-items/{id}",
     * summary="Busca um item de coleção pelo ID",
     * tags={"Collection Items"},
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\Response(response=200, description="Sucesso", @OA\JsonContent(ref="#/components/schemas/CollectionItem")),
     * @OA\Response(response=404, description="Item não encontrado")
     * )
     */
    public function show($id): JsonResponse
    {
        try {
            $item = $this->service->find($id);

            if (!$item) {
                return response()->json(['message' => 'CollectionItem não encontrada'], 404);
            }
            return response()->json(new \App\Http\Resources\CollectionItemResource($item), 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao buscar CollectionItem', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Post(
     * path="/api/admin/collection-items",
     * summary="Cria um novo item de coleção",
     * tags={"Collection Items"},
     * security={{"bearerAuth":{}}},
     * @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/StoreCollectionItemRequest")),
     * @OA\Response(response=201, description="Criado com sucesso", @OA\JsonContent(ref="#/components/schemas/CollectionItem")),
     * @OA\Response(response=422, description="Erro de validação")
     * )
     */
    public function store(StoreCollectionItemRequest $request): JsonResponse
    {
        try {
            $item = $this->service->store($request->validated());
            return response()->json($item, 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao criar CollectionItem',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Put(
     * path="/api/admin/collection-items/{id}",
     * summary="Atualiza um item de coleção",
     * tags={"Collection Items"},
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/UpdateCollectionItemRequest")),
     * @OA\Response(response=200, description="Atualizado com sucesso", @OA\JsonContent(ref="#/components/schemas/CollectionItem")),
     * @OA\Response(response=404, description="Item não encontrado")
     * )
     */
    public function update(UpdateCollectionItemRequest $request, $id): JsonResponse
    {
        try {
            $item = $this->service->update($id, $request->validated());
            return response()->json($item, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao atualizar CollectionItem',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
    /**
     * @OA\Delete(
     * path="/api/admin/collection-items/{id}",
     * summary="Deleta um item de coleção",
     * tags={"Collection Items"},
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\Response(response=200, description="Deletado com sucesso"),
     * @OA\Response(response=404, description="Item não encontrado")
     * )
     */
    public function destroy($id): JsonResponse
    {
        try {
            $this->service->delete($id);
            return response()->json(['message' => 'Item deletado com sucesso.']);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao deletar CollectionItem',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}