<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\StoreClientRequest;
use App\Http\Requests\Client\UpdateClientRequest;
use App\Http\Resources\ClientResource;
use App\Services\ClientService;
use Illuminate\Http\JsonResponse; // Importar JsonResponse para o type-hint

/**
 * @OA\Schema(
 * schema="StoreClientRequest",
 * type="object",
 * title="Store Client Request",
 * required={"nome", "cpf", "email", "data_nasc", "rg", "contato_1", "endereco", "cep", "uf", "cidade", "bairro", "numero"},
 * properties={
 * @OA\Property(property="nome", type="string", example="João da Silva"),
 * @OA\Property(property="cpf", type="string", example="123.456.789-10"),
 * @OA\Property(property="email", type="string", format="email", example="joao.silva@example.com"),
 * @OA\Property(property="data_nasc", type="string", format="date", example="1990-01-15"),
 * @OA\Property(property="rg", type="string", example="1234567"),
 * @OA\Property(property="contato_1", type="string", example="79999999999"),
 * @OA\Property(property="endereco", type="string", example="Rua das Flores"),
 * @OA\Property(property="cep", type="string", example="49000-000"),
 * @OA\Property(property="uf", type="string", example="SE"),
 * @OA\Property(property="cidade", type="string", example="Aracaju"),
 * @OA\Property(property="bairro", type="string", example="Centro"),
 * @OA\Property(property="numero", type="string", example="123"),
 * @OA\Property(property="user_id", type="integer", description="ID do usuário responsável", example=1, nullable=true)
 * }
 * )
 *
 * @OA\Schema(
 * schema="UpdateClientRequest",
 * type="object",
 * title="Update Client Request",
 * properties={
 * @OA\Property(property="nome", type="string", example="João da Silva Santos"),
 * @OA\Property(property="email", type="string", format="email", example="joao.santos@example.com")
 * }
 * )
 */
class ClientController extends Controller
{
    protected $service;

    public function __construct(ClientService $service)
    {
        $this->service = $service;
    }

    /**
     * @OA\Get(
     * path="/api/admin/clients",
     * summary="Lista todos os clientes",
     * tags={"Clients"},
     * security={{"bearerAuth":{}}},
     * @OA\Response(    
     * response=200,
     * description="Operação bem-sucedida",
     * @OA\JsonContent(type="array", @OA\Items(ref="#/components/schemas/Client"))
     * )
     * )
     */
    public function index()
    {
        return ClientResource::collection($this->service->list());
    }

    /**
     * @OA\Get(
     * path="/api/admin/clients/{id}",
     * summary="Busca um cliente pelo ID",
     * tags={"Clients"},
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * required=true,
     * description="ID do cliente",
     * @OA\Schema(type="integer")
     * ),
     * @OA\Response(
     * response=200,
     * description="Operação bem-sucedida",
     * @OA\JsonContent(ref="#/components/schemas/Client")
     * ),
     * @OA\Response(response=404, description="Cliente não encontrado")
     * )
     */
    public function show($id)
    {
        $client = $this->service->find($id);
        return new ClientResource($client);
    }

    /**
     * @OA\Post(
     * path="/api/admin/clients",
     * summary="Cria um novo cliente",
     * tags={"Clients"},
     * security={{"bearerAuth":{}}},
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(ref="#/components/schemas/StoreClientRequest")
     * ),
     * @OA\Response(
     * response=201,
     * description="Cliente criado com sucesso",
     * @OA\JsonContent(ref="#/components/schemas/Client")
     * ),
     * @OA\Response(response=422, description="Erro de validação")
     * )
     */
    public function store(StoreClientRequest $request): JsonResponse
    {
        try {
            $client = $this->service->store($request->validated());
            return response()->json(new ClientResource($client), 201);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao criar Cliente', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Put(
     * path="/api/admin/clients/{id}",
     * summary="Atualiza um cliente existente",
     * tags={"Clients"},
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * required=true,
     * @OA\Schema(type="integer")
     * ),
     * @OA\RequestBody(
     * required=true,
     * @OA\JsonContent(ref="#/components/schemas/UpdateClientRequest")
     * ),
     * @OA\Response(
     * response=200,
     * description="Cliente atualizado com sucesso",
     * @OA\JsonContent(ref="#/components/schemas/Client")
     * ),
     * @OA\Response(response=404, description="Cliente não encontrado")
     * )
     */
    public function update(UpdateClientRequest $request, $id): JsonResponse
    {
        try {
            $client = $this->service->update($id, $request->validated());
            return response()->json(new ClientResource($client), 200);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao atualizar Cliente', 'error' => $e->getMessage()], 500);
        }
    }

    /**
     * @OA\Delete(
     * path="/api/admin/clients/{id}",
     * summary="Deleta um cliente",
     * tags={"Clients"},
     * security={{"bearerAuth":{}}},
     * @OA\Parameter(
     * name="id",
     * in="path",
     * required=true,
     * @OA\Schema(type="integer")
     * ),
     * @OA\Response(
     * response=200,
     * description="Cliente deletado com sucesso",
     * @OA\JsonContent(properties={@OA\Property(property="message", type="string", example="Cliente deletado com sucesso.")})
     * ),
     * @OA\Response(response=404, description="Cliente não encontrado")
     * )
     */
    public function destroy($id): JsonResponse
    {
        try {
            $this->service->delete($id);
            return response()->json(['message' => 'Cliente deletado com sucesso.']);
        } catch (\Exception $e) {
            return response()->json(['message' => 'Erro ao deletar Cliente', 'error' => $e->getMessage()], 500);
        }
    }
}