<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\CollectionService;
use App\Http\Requests\Collection\StoreCollectionRequest;
use App\Http\Requests\Collection\UpdateCollectionRequest;
use App\Http\Resources\CollectionResource; // Assumindo que você tem um Resource para Collection
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Schema(
 * schema="StoreCollectionRequest",
 * title="Store Collection Request",
 * required={"name", "slug", "owner_id"},
 * @OA\Property(property="name", type="string", example="Leads do Site"),
 * @OA\Property(property="slug", type="string", example="leads-site"),
 * @OA\Property(property="owner_id", type="integer", example=1),
 * @OA\Property(property="client_id", type="integer", example=1, nullable=true),
 * @OA\Property(property="visibility", type="string", enum={"public", "private", "unlisted"}, example="private"),
 * @OA\Property(property="agency_access", type="boolean", example=true),
 * @OA\Property(property="icon", type="string", nullable=true, example="fa-users", description="Ícone associado à coleção"),
 * @OA\Property(property="description", type="string", nullable=true, description="Descrição detalhada sobre o propósito da coleção"),
 * @OA\Property(property="schema_json", type="object", example={"fields": {{"name": "email", "type": "email"}, {"name": "telefone", "type": "tel"}}})
 * )
 *
 * @OA\Schema(
 * schema="UpdateCollectionRequest",
 * title="Update Collection Request",
 * description="Todos os campos são opcionais. Envie apenas os que deseja alterar.",
 * @OA\Property(property="name", type="string", example="Leads Qualificados do Site"),
 * @OA\Property(property="slug", type="string", example="leads-qualificados-site"),
 * @OA\Property(property="owner_id", type="integer", example=1),
 * @OA\Property(property="client_id", type="integer", example=1, nullable=true),
 * @OA\Property(property="visibility", type="string", enum={"public", "private", "unlisted"}, example="private"),
 * @OA\Property(property="agency_access", type="boolean", example=false),
 * @OA\Property(property="icon", type="string", nullable=true, example="fa-star"),
 * @OA\Property(property="description", type="string", nullable=true, example="Coleção atualizada para leads qualificados."),
 * @OA\Property(property="schema_json", type="object", example={"fields": {{"name": "email", "type": "email"}, {"name": "status", "type": "string"}}})
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