<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\StoreProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Services\ProjectService;
use Illuminate\Http\JsonResponse;
use App\Models\Project;

/**
 * @OA\Schema(
 * schema="StoreProjectRequest",
 * type="object",
 * title="Store Project Request",
 * required={"client_id", "name", "status", "type_project", "date_project"},
 * properties={
 * @OA\Property(property="client_id", type="integer", example=1),
 * @OA\Property(property="name", type="string", example="Novo Projeto de Website"),
 * @OA\Property(property="status", type="string", description="Status do projeto", enum={"not_started", "raw", "started", "in_progress", "awaiting_approval", "completed", "postponed", "canceled"}, example="not_started"),
 * @OA\Property(property="type_project", type="string", example="Desenvolvimento"),
 * @OA\Property(property="date_project", type="string", format="date", example="2025-12-31"),
 * @OA\Property(property="visibility", type="string", enum={"public", "private"}, example="private", nullable=true),
 * @OA\Property(property="members", type="array", @OA\Items(type="integer"), example={1, 2}, nullable=true),
 * @OA\Property(property="description", type="string", example="Descrição detalhada do projeto.", nullable=true),
 * @OA\Property(property="link", type="string", format="url", example="https://projeto.com", nullable=true),
 * @OA\Property(property="goal", type="string", example="Aumentar as vendas em 20%", nullable=true)
 * }
 * )
 *
 * @OA\Schema(
 * schema="UpdateProjectRequest",
 * @OA\Property(property="name", type="string", example="Projeto de Marketing Atualizado"),
 * @OA\Property(property="status", type="string", example="completed"),
 * @OA\Property(property="visibility", type="string", enum={"public", "private"}, example="public"),
 * @OA\Property(property="members", type="array", @OA\Items(type="integer"), example={1, 3})
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
        $this->authorize('view', $project); // ✅ VERIFICA A PERMISSÃO
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
        $this->authorize('create', Project::class);
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
        $project = Project::findOrFail($id);
        $this->authorize('update', $project);
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
        $project = Project::findOrFail($id); 
        $this->authorize('delete', $project);
        try {
            $this->service->delete($id);
            return response()->json(['message' => 'Projeto deletado com sucesso.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao deletar Projeto', 'error'   => $e->getMessage()], 500);
        }
    }
}