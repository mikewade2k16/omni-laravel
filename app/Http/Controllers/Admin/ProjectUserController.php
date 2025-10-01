<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\ProjectUserService;
use App\Http\Requests\ProjectUser\StoreProjectUserRequest;
use App\Http\Requests\ProjectUser\UpdateProjectUserRequest;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Schema(
 * schema="StoreProjectUserRequest",
 * required={"user_id", "project_id"},
 * @OA\Property(property="user_id", type="integer", example=1),
 * @OA\Property(property="project_id", type="integer", example=1)
 * )
 */
class ProjectUserController extends Controller
{
    protected $service;

    public function __construct(ProjectUserService $service)
    {
        $this->service = $service;
    }

    /**
     * @OA\Get(
     * path="/api/admin/projects-user",
     * summary="Lista todas as associações entre usuários e projetos",
     * tags={"User Projects"},
     * security={{"bearerAuth":{}}},
     * @OA\Response(response=200, description="Sucesso", @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/ProjectUser")))
     * )
     */
    public function index()
    {
        return $this->service->list();
    }

    /**
     * @OA\Get(
     * path="/api/admin/projects-user/{id}",
     * summary="Busca uma associação pelo ID",
     * tags={"User Projects"},
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\Response(response=200, description="Sucesso", @OA\JsonContent(ref="#/components/schemas/ProjectUser")),
     * @OA\Response(response=404, description="Associação não encontrada")
     * )
     */
    public function show($id): JsonResponse
    {
        try {
            $projectUser = $this->service->find($id);

            if (!$projectUser) {
                return response()->json(['message' => 'ProjectUser não encontrada'], 404);
            }
            return response()->json(new \App\Http\Resources\ProjectUserResource($projectUser), 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao buscar ProjectUser', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Post(
     * path="/api/admin/projects-user",
     * summary="Cria uma nova associação entre usuário e projeto",
     * tags={"User Projects"},
     * security={{"bearerAuth":{}}},
     * @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/StoreProjectUserRequest")),
     * @OA\Response(response=201, description="Criado com sucesso", @OA\JsonContent(ref="#/components/schemas/ProjectUser")),
     * @OA\Response(response=422, description="Erro de validação")
     * )
     */
    public function store(StoreProjectUserRequest $request): JsonResponse
    {
        try {
            $ProjectUser = $this->service->store($request->validated());
            return response()->json($ProjectUser, 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao criar ProjectUser',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Put(
     * path="/api/admin/projects-user/{id}",
     * summary="Atualiza uma associação (não comum, geralmente se deleta e cria)",
     * tags={"User Projects"},
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/StoreProjectUserRequest")),
     * @OA\Response(response=200, description="Atualizado com sucesso", @OA\JsonContent(ref="#/components/schemas/ProjectUser")),
     * @OA\Response(response=404, description="Associação não encontrada")
     * )
     */
    public function update(UpdateProjectUserRequest $request, $id): JsonResponse
    {
        try {
            $ProjectUser = $this->service->update($id, $request->validated());
            return response()->json($ProjectUser, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao atualizar ProjectUser',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Delete(
     * path="/api/admin/projects-user/{id}",
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
            return response()->json(['message' => 'ProjectUser deletado com sucesso.']);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao deletar ProjectUser',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}