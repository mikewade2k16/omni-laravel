<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Project\UpdatePreferenceRequest;
use App\Models\Project;
use App\Services\ProjectPreferenceService;
use Illuminate\Http\JsonResponse;

class ProjectPreferenceController extends Controller
{
    protected $service;

    public function __construct(ProjectPreferenceService $service)
    {
        $this->service = $service;
    }

    public function update(UpdatePreferenceRequest $request, Project $project): JsonResponse
    {
        $preference = $this->service->updateOrCreateForUser(
            $project,
            $request->user(),
            $request->validated()['settings']
        );

        return response()->json($preference, 200);
    }
}