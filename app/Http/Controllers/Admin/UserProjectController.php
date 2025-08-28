<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\UserProjectService;
use App\Http\Requests\StoreUserProjectRequest;
use App\Http\Requests\UpdateUserProjectRequest;
use App\Http\Resources\UserProjectResource;

class UserProjectController extends Controller
{
    protected $service;

    public function __construct(UserProjectService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return UserProjectResource::collection($this->service->all());
    }

    public function store(StoreUserProjectRequest $request)
    {
        $userProject = $this->service->store($request->validated());
        return new UserProjectResource($userProject);
    }

    public function show($id)
    {
        return new UserProjectResource($this->service->find($id));
    }

    public function update(UpdateUserProjectRequest $request, $id)
    {
        $userProject = $this->service->update($id, $request->validated());
        return new UserProjectResource($userProject);
    }

    public function destroy($id)
    {
        $this->service->delete($id);
        return response()->json(['message' => 'Deleted successfully']);
    }
}
