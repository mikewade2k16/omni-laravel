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

    // Criar um usuário
    public function store(StoreUserRequest $request)
    {
        Log::info('Storing User:');
        $user = $this->service->store($request->validated());
        return new UserResource($user);
    }

    // Visualizar um usuário específico
    public function show($id)
    {
        $user = $this->service->find($id);
        return new UserResource($user);
    }

    // Atualizar um usuário
    public function update(UpdateUserRequest $request, $id)
    {
        $task = $this->service->update($id, $request->validated());
        return new UserResource($task);
    }

    public function delete($id)
    {
        $this->service->delete($id);
        return response()->json(['message' => 'Usuário deletado com sucesso.']);
    }
}   
