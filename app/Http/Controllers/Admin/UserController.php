<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class UserController extends Controller
{
    protected $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    // Listar todos os usuários
    public function index()
    {
        return UserResource::collection($this->service->list());
    }

    // Visualizar um usuário específico
    public function show($id)
    {
        $user = $this->service->find($id);
        return new UserResource($user);
    }

    // Criar um usuário
    public function store(StoreUserRequest $request)
    {
        try {
            $user = $this->service->store($request->validated());
            return response()->json($user, 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao criar usuário',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    // Atualizar um usuário
    public function update(UpdateUserRequest $request, $id)
    {
        try {
            $user = $this->service->update($id, $request->validated());
            return response()->json($user, 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao atualizar usuário',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    // Deletar um usuário
    public function destroy($id)
    {
        try {
            $this->service->destroy($id);
            return response()->json(['message' => 'Usuário deletado com sucesso.']);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao deletar usuário',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}
