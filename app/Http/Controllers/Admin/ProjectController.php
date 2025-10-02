<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\StoreProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Services\ProjectService;
use Illuminate\Http\JsonResponse;
use App\Models\Project;
use App\Http\Requests\Project\UpdatePreferenceRequest;
use App\Services\ProjectPreferenceService;

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
 * @OA\Property(property="visibility", type="string", enum={"public", "private"}, example="public"),
* @OA\Property(
* property="members",
* type="array",
* description="Array of user IDs to be members of the project.",
* nullable=true,
* example="[1, 2]",
* @OA\Items(type="integer")
* ),
 * @OA\Property(property="type_project", type="string", maxLength=50, example="Web Development"),
 * @OA\Property(property="link", type="string", format="url", maxLength=255, nullable=true, example="https://example.com/project-link"),
 * @OA\Property(property="goal", type="string", maxLength=255, nullable=true, example="Increase user engagement by 20%"),
 * @OA\Property(property="description", type="string", nullable=true, example="A very detailed description of the project goals and deliverables."),
 * @OA\Property(property="date_project", type="string", format="date", example="2025-12-31"),
 * @OA\Property(property="category", type="string", maxLength=100, nullable=true, example="Marketing"),
 * @OA\Property(property="segment", type="string", maxLength=100, nullable=true, example="B2B"),
 * @OA\Property(
 * property="settings",
 * type="object",
 * nullable=true,
 * @OA\Property(property="view_type", type="string", enum={"card", "list"}, example="list")
 * ),
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
 * 
 * @OA\Schema(
 * schema="UpdatePreferenceRequest",
 * type="object",
 * title="Update Preference Request",
 * required={"settings"},
 * properties={
 * @OA\Property(
 * property="settings",
 * type="object",
 * description="Configurações de preferência do usuário",
 * @OA\Property(property="view_type", type="string", enum={"card", "list"}, example="list")
 * )
 * }
 * )
 */
class ProjectController extends Controller
{
    protected $preferenceService;

    public function __construct(ProjectService $service, ProjectPreferenceService $preferenceService)
    {
        $this->service = $service;
        $this->preferenceService = $preferenceService;
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
    public function show($id): JsonResponse
    {
        try {
            $project = $this->service->find($id);

            if (!$project) {
                return response()->json(['message' => 'Projeto não encontrado'], 404);
            }
            return response()->json(new ProjectResource($project), 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao buscar projeto', 'error' => $e->getMessage()], 500);
        }
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
/**
     * @OA\Put(
     * path="/api/admin/projects/{id}/preferences",
     * summary="Atualiza as preferências do usuário para um projeto",
     * tags={"Projects"},
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(name="id", in="path", required=true, description="ID do projeto",
     * @OA\Schema(type="integer")
     * ),
     * @OA\RequestBody( required=true, description="Objeto com as configurações de preferência",
     * @OA\JsonContent(ref="#/components/schemas/UpdatePreferenceRequest")
     * ),
     * @OA\Response( response=200, description="Preferências atualizadas com sucesso",
     * @OA\JsonContent( type="object", example={ "id": 1, "user_id": 1, "preferable_id": 15, "preferable_type": "App\\Models\\Project", "settings": { "view_type": "list" }
     * }
     * )
     * ),
     * @OA\Response(response=403, description="Ação não autorizada"),
     * @OA\Response(response=404, description="Projeto não encontrado"),
     * @OA\Response(response=422, description="Erro de validação de dados")
     * )
     */
    public function updatePreferences(UpdatePreferenceRequest $request, $id): JsonResponse
    {
        $project = Project::findOrFail($id);

        $preference = $this->preferenceService->updateOrCreateForUser(
            $project,
            $request->user(),
            $request->validated()['settings']
        );

        return response()->json($preference, 200);
    }
}