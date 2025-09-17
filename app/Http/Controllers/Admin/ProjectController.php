<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\StoreProjectRequest;
use App\Http\Requests\Project\UpdateProjectRequest;
use App\Http\Resources\ProjectResource;
use App\Services\ProjectService;
use Illuminate\Http\JsonResponse;

class ProjectController extends Controller
{
    protected $service;

    public function __construct(ProjectService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        $projects = $this->service->list();
        return ProjectResource::collection($projects);
    }

    public function show($id)
    {
        $project = $this->service->find($id);
        return new ProjectResource($project);
    }

    public function store(StoreProjectRequest $request): JsonResponse
    {
        try {
            $project = $this->service->store($request->validated());
            return response()->json(new ProjectResource($project), 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao criar Projeto',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function update(UpdateProjectRequest $request, $id): JsonResponse
    {
        try {
            $project = $this->service->update($id, $request->validated());
            return response()->json(new ProjectResource($project), 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao atualizar Projeto',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id): JsonResponse
    {
        try {
            $this->service->destroy($id);
            return response()->json(['message' => 'Projeto deletado com sucesso.']);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao deletar Projeto',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}
