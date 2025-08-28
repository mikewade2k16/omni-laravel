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

    public function store(StoreProjectRequest $request)
    {
        $project = $this->service->store($request->validated());
        return new ProjectResource($project);
    }

    public function show($id)
    {
        $project = $this->service->find($id);
        return new ProjectResource($project);
    }

    public function update(UpdateProjectRequest $request, $id)
    {
        $project = $this->service->update($id, $request->validated());
        return new ProjectResource($project);
    }

    public function delete($id)
    {
        $this->service->delete($id);
        return response()->json(['message' => 'Project deleted successfully']);
    }
}
