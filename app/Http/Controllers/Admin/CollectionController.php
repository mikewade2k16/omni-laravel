<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\CollectionService;
use App\Http\Requests\Collection\StoreCollectionRequest;
use App\Http\Requests\Collection\UpdateCollectionRequest;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Schema(
 * schema="StoreCollectionRequest",
 * required={"name", "slug", "owner_id"},
 * @OA\Property(property="name", type="string", example="Leads do Site"),
 * @OA\Property(property="slug", type="string", example="leads-site"),
 * @OA\Property(property="owner_id", type="integer", example=1),
 * @OA\Property(property="client_id", type="integer", example=1, nullable=true),
 * @OA\Property(property="visibility", type="string", example="private"),
 * @OA\Property(property="agency_access", type="boolean", example=true),
 * @OA\Property(property="schema_json", type="object", example={"campo_email": "email", "campo_telefone": "tel"})
 * )
 *
 * @OA\Schema(
 * schema="UpdateCollectionRequest",
 * @OA\Property(property="name", type="string", example="Leads Qualificados do Site")
 * )
 */
class CollectionController extends Controller
{
    protected $service;

    public function __construct(CollectionService $service)
    {
        $this->service = $service;
    }

    /**
     * @OA\Get(
     * path="/api/admin/collections",
     * summary="Lista todas as coleções",
     * tags={"Collections"},
     * security={{"bearerAuth":{}}},
     * @OA\Response(response=200, description="Sucesso", @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Collection")))
     * )
     */
    public function index()
    {
        return $this->service->list();
    }

    /**
     * @OA\Get(
     * path="/api/admin/collections/{id}",
     * summary="Busca uma coleção pelo ID",
     * tags={"Collections"},
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\Response(response=200, description="Sucesso", @OA\JsonContent(ref="#/components/schemas/Collection")),
     * @OA\Response(response=404, description="Coleção não encontrada")
     * )
     */
    public function show($id)
    {
        return $this->service->find($id);
    }

    /**
     * @OA\Post(
     * path="/api/admin/collections",
     * summary="Cria uma nova coleção",
     * tags={"Collections"},
     * security={{"bearerAuth":{}}},
     * @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/StoreCollectionRequest")),
     * @OA\Response(response=201, description="Criado com sucesso", @OA\JsonContent(ref="#/components/schemas/Collection")),
     * @OA\Response(response=422, description="Erro de validação")
     * )
     */
    public function store(StoreCollectionRequest $request): JsonResponse
    {
        try {
            $collection = $this->service->store($request->validated());
            return response()->json($collection, 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao criar Collection', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Put(
     * path="/api/admin/collections/{id}",
     * summary="Atualiza uma coleção",
     * tags={"Collections"},
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/UpdateCollectionRequest")),
     * @OA\Response(response=200, description="Atualizado com sucesso", @OA\JsonContent(ref="#/components/schemas/Collection")),
     * @OA\Response(response=404, description="Coleção não encontrada")
     * )
     */
    public function update(UpdateCollectionRequest $request, $id): JsonResponse
    {
        try {
            $collection = $this->service->update($id, $request->validated());
            return response()->json($collection, 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao atualizar Collection', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Delete(
     * path="/api/admin/collections/{id}",
     * summary="Deleta uma coleção",
     * tags={"Collections"},
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\Response(response=200, description="Deletado com sucesso"),
     * @OA\Response(response=404, description="Coleção não encontrada")
     * )
     */
    public function destroy($id): JsonResponse
    {
        try {
            $this->service->delete($id);
            return response()->json(['message' => 'Collection deletada com sucesso.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao deletar Collection', 'error' => $e->getMessage()], 500);
        }
    }
}