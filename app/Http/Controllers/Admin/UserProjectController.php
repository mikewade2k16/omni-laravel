<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\UserProjectService;
use App\Http\Requests\UserProject\StoreUserProjectRequest;
use App\Http\Requests\UserProject\UpdateUserProjectRequest;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Schema(
 * schema="StoreUserProjectRequest",
 * required={"user_id", "project_id"},
 * @OA\Property(property="user_id", type="integer", example=1),
 * @OA\Property(property="project_id", type="integer", example=1)
 * )
 */
class UserProjectController extends Controller
{
    protected $service;

    public function __construct(UserProjectService $service)
    {
        $this->service = $service;
    }

    /**
     * @OA\Get(
     * path="/api/admin/user-projects",
     * summary="Lista todas as associações entre usuários e projetos",
     * tags={"User Projects"},
     * security={{"bearerAuth":{}}},
     * @OA\Response(response=200, description="Sucesso", @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/UserProject")))
     * )
     */
    public function index()
    {
        return $this->service->list();
    }

    /**
     * @OA\Get(
     * path="/api/admin/user-projects/{id}",
     * summary="Busca uma associação pelo ID",
     * tags={"User Projects"},
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\Response(response=200, description="Sucesso", @OA\JsonContent(ref="#/components/schemas/UserProject")),
     * @OA\Response(response=404, description="Associação não encontrada")
     * )
     */
    public function show($id)
    {
        return $this->service->find($id);
    }

    /**
     * @OA\Post(
     * path="/api/admin/user-projects",
     * summary="Cria uma nova associação entre usuário e projeto",
     * tags={"User Projects"},
     * security={{"bearerAuth":{}}},
     * @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/StoreUserProjectRequest")),
     * @OA\Response(response=201, description="Criado com sucesso", @OA\JsonContent(ref="#/components/schemas/UserProject")),
     * @OA\Response(response=422, description="Erro de validação")
     * )
     */
    public function store(StoreUserProjectRequest $request): JsonResponse
    {
        try {
            $userProject = $this->service->store($request->validated());
            return response()->json($userProject, 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao criar UserProject',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Put(
     * path="/api/admin/user-projects/{id}",
     * summary="Atualiza uma associação (não comum, geralmente se deleta e cria)",
     * tags={"User Projects"},
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/StoreUserProjectRequest")),
     * @OA\Response(response=200, description="Atualizado com sucesso", @OA\JsonContent(ref="#/components/schemas/UserProject")),
     * @OA\Response(response=404, description="Associação não encontrada")
     * )
     */
    public function update(UpdateUserProjectRequest $request, $id): JsonResponse
    {
        try {
            $userProject = $this->service->update($id, $request->validated());
            return response()->json($userProject, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao atualizar UserProject',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Delete(
     * path="/api/admin/user-projects/{id}",
     * summary="Deleta uma associação entre usuário e projeto",
     * tags={"User Projects"},
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\Response(response=200, description="Deletado com sucesso"),
     * @OA\Response(response=404, description="Associação não encontrada")
     * )
     */
    public function destroy($id): JsonResponse
    {
        try {
            $this->service->delete($id);
            return response()->json(['message' => 'UserProject deletado com sucesso.']);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao deletar UserProject',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}