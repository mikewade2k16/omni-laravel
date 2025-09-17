<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Client\StoreClientRequest;
use App\Http\Requests\Client\UpdateClientRequest;
use App\Http\Resources\ClientResource;
use App\Services\ClientService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class ClientController extends Controller
{
    protected $service;

    public function __construct(ClientService $service)
    {
        $this->service = $service;
    }

    public function index()
    {
        return ClientResource::collection($this->service->list());
    }

    public function show($id)
    {
        $client = $this->service->find($id);
        return new ClientResource($client);
    }

    public function store(StoreClientRequest $request)
    {
        try {
            $client = $this->service->store($request->validated());
            return response()->json(new ClientResource($client), 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao criar Cliente',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function update(UpdateClientRequest $request, $id)
    {
        try {
            $client = $this->service->update($id, $request->validated());
            return response()->json(new ClientResource($client), 201);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao atualizar Cliente',
                'error'   => $e->getMessage()
            ], 500);
        }
    }

    public function destroy($id)
    {
        try {
            $this->service->destroy($id);
            return response()->json(['message' => 'Cliente deletado com sucesso.']);
        } catch (\Exception $e) {
            return response()->json([
                'message' => 'Erro ao deletar Cliente',
                'error'   => $e->getMessage()
            ], 500);
        }
    }
}
