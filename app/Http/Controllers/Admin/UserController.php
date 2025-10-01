<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\User\StoreUserRequest;
use App\Http\Requests\User\UpdateUserRequest;
use App\Http\Resources\UserResource;
use App\Services\UserService;
use Illuminate\Http\JsonResponse;

/**
 * @OA\Schema(
 * schema="StoreUserRequest",
 * required={"name", "email", "password", "nick", "status", "level", "user_type"},
 * @OA\Property(property="name", type="string", example="Edson Oliveira"),
 * @OA\Property(property="email", type="string", format="email", example="edson.oliveira@example.com"),
 * @OA\Property(property="password", type="string", format="password", example="senha123"),
 * @OA\Property(property="password_confirmation", type="string", format="password", example="senha123"),
 * @OA\Property(property="nick", type="string", example="edinho"),
 * @OA\Property(property="status", type="string", enum={"active", "inactive"}, example="active"),
 * @OA\Property(property="level", type="string", enum={"admin", "manager", "marketing", "finance"}, example="marketing"),
 * @OA\Property(property="user_type", type="string", enum={"client", "admin"}, example="client")
 * )
 *
 * @OA\Schema(
 * schema="UpdateUserRequest",
 * @OA\Property(property="name", type="string", example="Edson Oliveira Jr."),
 * @OA\Property(property="status", type="string", enum={"active", "inactive"}, example="inactive")
 * )
 */
class UserController extends Controller
{
    protected $service;

    public function __construct(UserService $service)
    {
        $this->service = $service;
    }

    /**
     * @OA\Get(
     * path="/api/admin/users",
     * summary="Lista todos os usuários",
     * tags={"Users"},
     * security={{"bearerAuth":{}}},
     * @OA\Response(response=200, description="Sucesso", @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/User")))
     * )
     */
    public function index()
    {
        return UserResource::collection($this->service->list());
    }

    /**
     * @OA\Get(
     * path="/api/admin/users/{id}",
     * summary="Busca um usuário pelo ID",
     * tags={"Users"},
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\Response(response=200, description="Sucesso", @OA\JsonContent(ref="#/components/schemas/User")),
     * @OA\Response(response=404, description="Usuário não encontrado")
     * )
     */
    public function show($id)
    {
        $user = $this->service->find($id);
        return new UserResource($user);
    }

    /**
     * @OA\Post(
     * path="/api/admin/users",
     * summary="Cria um novo usuário",
     * tags={"Users"},
     * security={{"bearerAuth":{}}},
     * @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/StoreUserRequest")),
     * @OA\Response(response=201, description="Criado com sucesso", @OA\JsonContent(ref="#/components/schemas/User")),
     * @OA\Response(response=422, description="Erro de validação")
     * )
     */
    public function store(StoreUserRequest $request): JsonResponse
    {
        try {
            $user = $this->service->store($request->validated());
            return response()->json(new UserResource($user), 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao criar usuário',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Put(
     * path="/api/admin/users/{id}",
     * summary="Atualiza um usuário",
     * tags={"Users"},
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\RequestBody(required=true, @OA\JsonContent(ref="#/components/schemas/UpdateUserRequest")),
     * @OA\Response(response=200, description="Atualizado com sucesso", @OA\JsonContent(ref="#/components/schemas/User")),
     * @OA\Response(response=404, description="Usuário não encontrado")
     * )
     */
    public function update(UpdateUserRequest $request, $id): JsonResponse
    {
        try {
            $user = $this->service->update($id, $request->validated());
            return response()->json(new UserResource($user), 200);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao atualizar usuário',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    /**
     * @OA\Delete(
     * path="/api/admin/users/{id}",
     * summary="Deleta um usuário",
     * tags={"Users"},
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(name="id", in="path", required=true, @OA\Schema(type="integer")),
     * @OA\Response(response=200, description="Deletado com sucesso"),
     * @OA\Response(response=404, description="Usuário não encontrado")
     * )
     */
    public function destroy($id): JsonResponse
    {
        try {
            $this->service->delete($id);
            return response()->json(['message' => 'Usuário deletado com sucesso.']);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao deletar usuário',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}