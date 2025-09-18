<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\StoreProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Services\ProjectService;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Schema(
 * schema="StoreProjectRequest",
 * required={"client_id", "name", "status"},
 * @OA\Property(property="client_id", type="integer", example=1),
 * @OA\Property(property="name", type="string", example="Novo Projeto de Marketing"),
 * @OA\Property(property="status", type="string", example="not_started"),
 * @OA\Property(property="description", type="string", example="Descrição detalhada do projeto.")
 * )
 *
 * @OA\Schema(
 * schema="UpdateProjectRequest",
 * @OA\Property(property="name", type="string", example="Projeto de Marketing Atualizado"),
 * @OA\Property(property="status", type="string", example="completed")
 * )
 */
class ProjectController extends Controller
{
    protected $service;

    public function __construct(ProjectService $service)
    {
        $this->service = $service;
    }

    /**
     * @OA\Get(
     * path="/api/admin/projects",
     * summary="Lista todos os projetos",
     * tags={"Projects"},
     * security={{"bearerAuth":{}}},
     * @OA\Response(response=200, description="Sucesso", @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Project")))
     * )
     */
    public function index()
    {
        $projects = $this->service->list();
        return ProjectResource::collection($projects);
    }

    /**
     * @OA\Get(
     * path="/api/admin/projects/{id}",
     * summary="Busca um projeto pelo ID",
     * tags={"Projects"},
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\Response(response=200, description="Sucesso", @OA\JsonContent(ref="#/components/schemas/Project")),
     * @OA\Response(response=404, description="Projeto não encontrado")
     * )
     */
    public function show($id)
    {
        $project = $this->service->find($id);
        return new ProjectResource($project);
    }

    /**
     * @OA\Post(
     * path="/api/admin/projects",
     * summary="Cria um novo projeto",
     * tags={"Projects"},
     * security={{"bearerAuth":{}}},
     * @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/StoreProjectRequest")),
     * @OA\Response(response=201, description="Criado com sucesso", @OA\JsonContent(ref="#/components/schemas/Project")),
     * @OA\Response(response=422, description="Erro de validação")
     * )
     */
    public function store(StoreProjectRequest $request): JsonResponse
    {
        try {
            $project = $this->service->store($request->validated());
            return response()->json(new ProjectResource($project), 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao criar Projeto', 'error'   => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Put(
     * path="/api/admin/projects/{id}",
     * summary="Atualiza um projeto",
     * tags={"Projects"},
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/UpdateProjectRequest")),
     * @OA\Response(response=200, description="Atualizado com sucesso", @OA\JsonContent(ref="#/components/schemas/Project")),
     * @OA\Response(response=404, description="Projeto não encontrado")
     * )
     */
    public function update(UpdateProjectRequest $request, $id): JsonResponse
    {
        try {
            $project = $this->service->update($id, $request->validated());
            return response()->json(new ProjectResource($project), 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao atualizar Projeto', 'error'   => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Delete(
     * path="/api/admin/projects/{id}",
     * summary="Deleta um projeto",
     * tags={"Projects"},
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\Response(response=200, description="Deletado com sucesso"),
     * @OA\Response(response=404, description="Projeto não encontrado")
     * )
     */
    public function destroy($id): JsonResponse
    {
        try {
            $this->service->delete($id);
            return response()->json(['message' => 'Projeto deletado com sucesso.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao deletar Projeto', 'error'   => $e->getMessage()], 500);
        }
    }
}