<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Column\StoreColumnRequest;
use App\Http\Requests\Column\UpdateColumnRequest;
use App\Http\Resources\ColumnResource;
use App\Services\ColumnService;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Schema(
 * schema="StoreColumnRequest",
 * type="object",
 * title="Store Column Request",
 * required={"project_id", "name"},
 * properties={
 * @OA\Property(property="project_id", type="integer", description="ID do projeto ao qual a coluna pertence", example=1),
 * @OA\Property(property="name", type="string", description="Nome da coluna", example="A Fazer")
 * }
 * )
 *
 * @OA\Schema(
 * schema="UpdateColumnRequest",
 * type="object",
 * title="Update Column Request",
 * properties={
 * @OA\Property(property="name", type="string", description="Novo nome da coluna")
 * }
 * )
 */
class ColumnController extends Controller
{
    protected $service;

    public function __construct(ColumnService $service)
    {
        $this->service = $service;
    }

    /**
     * @OA\Get(
     * path="/api/admin/columns",
     * summary="Lista todas as colunas",
     * tags={"Columns"},
     * security={{"bearerAuth":{}}},
     * @OA\Response(
     * response=200,
     * description="Operação bem-sucedida",
     * @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Column"))
     * )
     * )
     */
    public function index()
    {
        $columns = $this->service->list();
        return ColumnResource::collection($columns);
    }

    /**
     * @OA\Get(
     * path="/api/admin/columns/{id}",
     * summary="Busca uma coluna pelo ID",
     * tags={"Columns"},
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * required=true,
     * description="ID da coluna",
     * @OA\Schema(type="integer")
     * ),
     * @OA\Response(
     * response=200,
     * description="Operação bem-sucedida",
     * @OA\JsonContent(ref="#/components/schemas/Column")
     * ),
     * @OA\Response(response=404, description="Coluna não encontrada")
     * )
     */
    public function show($id): JsonResponse
    {
        try {
            $column = $this->service->find($id);

            if (!$column) {
                return response()->json(['message' => 'Coluna não encontrada'], 404);
            }
            return response()->json(new ColumnResource($column), 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao buscar coluna', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Post(
     * path="/api/admin/columns",
     * summary="Cria uma nova coluna",
     * tags={"Columns"},
     * security={{"bearerAuth":{}}},
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(ref="#/components/schemas/StoreColumnRequest")
     * ),
     * @OA\Response(
     * response=201,
     * description="Coluna criada com sucesso",
     * @OA\JsonContent(ref="#/components/schemas/Column")
     * ),
     * @OA\Response(response=422, description="Erro de validação")
     * )
     */
    public function store(StoreColumnRequest $request): JsonResponse
    {
        try {
            $column = $this->service->store($request->validated());
            return response()->json(new ColumnResource($column), 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao criar Coluna', 'error'   => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Put(
     * path="/api/admin/columns/{id}",
     * summary="Atualiza uma coluna existente",
     * tags={"Columns"},
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * required=true,
     * description="ID da coluna a ser atualizada",
     * @OA\Schema(type="integer")
     * ),
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(ref="#/components/schemas/UpdateColumnRequest")
     * ),
     * @OA\Response(
     * response=200,
     * description="Coluna atualizada com sucesso",
     * @OA\JsonContent(ref="#/components/schemas/Column")
     * ),
     * @OA\Response(response=404, description="Coluna não encontrada"),
     * @OA\Response(response=422, description="Erro de validação")
     * )
     */
    public function update(UpdateColumnRequest $request, $id): JsonResponse
    {
        try {
            $column = $this->service->update($id, $request->validated());
            return response()->json(new ColumnResource($column), 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao atualizar Coluna', 'error'   => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Delete(
     * path="/api/admin/columns/{id}",
     * summary="Deleta uma coluna",
     * tags={"Columns"},
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * required=true,
     * description="ID da coluna a ser deletada",
     * @OA\Schema(type="integer")
     * ),
     * @OA\Response(
     * response=200,
     * description="Coluna deletada com sucesso",
     * @OA\JsonContent(properties={@OA\Property(property="message", type="string")})
     * ),
     * @OA\Response(response=404, description="Coluna não encontrada")
     * )
     */
    public function destroy($id): JsonResponse
    {
        try {
            $this->service->delete($id);
            return response()->json(['message' => 'Coluna deletada com sucesso.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao deletar Coluna', 'error'   => $e->getMessage()], 500);
        }
    }
}