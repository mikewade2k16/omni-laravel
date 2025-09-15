<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Services\UserProjectService;
use App\Http\Requests\UserProject\StoreUserProjectRequest;
use App\Http\Requests\UserProject\UpdateUserProjectRequest;

class UserProjectController extends Controller
{
    protected $service;

    public function __construct(UserProjectService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return $this->service->list();
    }

    public function show($id)
    {
        return $this->service->find($id);
    }

    public function store(StoreUserProjectRequest $request)
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

    public function update(UpdateUserProjectRequest $request, $id)
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

    public function destroy($id)
    {
        try {
            $this->service->destroy($id);
            return response()->json(['message' => 'UserProject deletado com sucesso.']);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao deletar UserProject',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}
